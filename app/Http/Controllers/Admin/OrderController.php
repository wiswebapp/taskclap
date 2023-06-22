<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Repositories\Admin\OrderRepository;
use App\Repositories\Admin\ProviderRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct(
        private ProviderRepository $providerRepository,
        private OrderRepository $orderRepository,
    )
    {
        //
    }

    public function index(): View
    {
        return view('admin.order.index', [
            'orderData' => Order::orderby('id', 'desc')->paginate(10),
        ]);
    }

    public function orderDetail(Order $order): View
    {
        $providerList = $this->providerRepository->getRaw()->select(['id','name'])->where('category_id', 'like', '%'.$order->sub_category_id.'%')->where('status', 'Active')->get();

        return view('admin.order.detail', [
            'order' => $order,
            'orderStatus' => collect(Order::ORDER_STATUS)->reject(function (string $name) use($order) {
                return $order->order_status === $name;
            }),
            'paymentStatus' => collect(Order::PAYMENT_STATUS)->reject(function (string $name) use($order) {
                return $order->payment_status === $name;
            }),
            'providerList' => $providerList,
        ]);
    }

    public function updateOrderDetail(Request $request, Order $order): RedirectResponse
    {
        $redirectRoute = route('admin.orders.detail', $order);

        switch ($request->type) {
            case 'assign_provider':
                $msg = $this->assignProvider($request, $order);
                break;
            case 'add_material_charge':
                $msg = $this->addCharges($request, $order, 'material');
                break;
            case 'add_additional_charge':
                $msg = $this->addCharges($request, $order, 'additional');
                break;
            case 'order_status':
                $msg = $this->updateStatus($request, $order);
                break;
            case 'mark_as_paid_for_provider':
                $msg = $this->markAsPaidToProvider($order);
                $redirectRoute = route('admin.report.payment', $order);
                break;
            default:
                die('Unknown Type');
                break;
        }

        return redirect($redirectRoute)->with('success', $msg);
    }

    public function assignProvider(Request $request, Order $order): String
    {
        $request->validate(['provider_id' => 'required|int']);
        $this->orderRepository->update($order->id, [
            'provider_id' => $request->provider_id
        ]);

        return "Provider assigned Successfully !";
    }

    public function addCharges(Request $request, Order $order, $chargeType): String
    {
        if ($chargeType == "material") {
            $request->validate([
                'orderDetailId' => 'required',
                'material_charge' => 'required|int|gt:0',
                'material_charge_actual' => 'required|int|gt:0',
                'material_description' => 'required|min:3|max:500',
            ]);

            $this->orderRepository->updateOrderDetailWithDetailId($request->orderDetailId, [
                'material_charge' => $request->material_charge,
                'material_charge_actual' => $request->material_charge_actual,
                'material_description' => $request->material_description,
            ]);
            $this->orderRepository->update($order->id, [
                'material_charge_amount_total' =>  $request->material_charge,
                'total' => DB::Raw('total + ' . $request->material_charge),
            ]);
        } else {
            $request->validate([
                'orderDetailId' => 'required',
                'additional_charge' => 'required|int|gt:0',
                'additional_charge_description' => 'required|min:3|max:500',
            ]);

            $this->orderRepository->updateOrderDetailWithDetailId($request->orderDetailId, [
                'additional_charge' => $request->additional_charge,
                'additional_charge_description' => $request->additional_charge_description,
            ]);
            $this->orderRepository->update($order->id, [
                'additional_charge_amount_total' =>  $request->additional_charge,
                'total' => DB::Raw('total + ' . $request->additional_charge),
            ]);
        }

        return ucfirst($chargeType) . " Charge updated Successfully !";
    }

    public function updateStatus(Request $request, Order $order)
    {
        $this->orderRepository->update($order->id, $request->validate([
            'order_status' => 'nullable',
            'payment_status' => 'required_with:payment_type',
            'payment_type' => 'required_with:payment_status'
        ]));

        return "Order Status Updated Successfully !";
    }

    public function markAsPaidToProvider(Order $order)
    {
        $order->update(['is_paid_to_provider' => 'Yes']);
        return "Order Updated Successfully !";
    }

    public function paymentReport(Request $request)
    {
        $paymentReportData = $this->orderRepository->getPaymentReportData($request->all());

        return view('admin.report.payment', [
            'params' => $request->all(),
            'pageData' => $paymentReportData
        ]);
    }
}
