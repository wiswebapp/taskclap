<?php

namespace App\Http\Controllers;

use App\Http\Traits\GeneralFunctions;
use App\Http\Traits\StripeFunctions;
use App\Repositories\Admin\OrderRepository;
use Illuminate\Http\RedirectResponse;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\Response;

class BookingController extends Controller
{
    use GeneralFunctions, StripeFunctions;

    public function __construct(private OrderRepository $orderRepository,)
    {
        //
    }

    public function index() : View|RedirectResponse
    {
        $loggedInUser = auth()->user();
        if (! $loggedInUser) {
            return redirect(route('login'));
        }
        $orderData = $this->orderRepository->get($loggedInUser->id);
        $orderData->map(function ($order) {
            $order->orderDetail->map(function ($orderDetail) use ($order) {
                if ($order->order_status == "Completed") {
                    $desired_object = $order->ratings->first(function ($item) use($orderDetail) {
                        return $item->product_id == $orderDetail->product_id;
                    });

                    if($desired_object) {
                        $orderDetail->isRate = true;
                        $orderDetail->rating = $desired_object->rating;
                    } else {
                        $orderDetail->isRate = false;
                        $orderDetail->rating = 0;
                    }
                }
            });
        });

        return view('my_bookings', [
            'pageData' => $orderData,
        ]);
    }

    public function charge(Request $request) {
        // header('Content-Type: application/json');
        $cartItems = json_decode(base64_decode($request->cartArray), true);
        $cartDetail = array_filter(getCartItems());

        for ($i=0; $i< count($cartItems); $i++) {
            $cartItems[$i]['qty'] = $cartDetail[$cartItems[$i]['id']];
        }

        $checkout_session = $this->generateCheckoutSession($cartItems);
        if (empty($checkout_session)) {
            header("Location: " . route('orderFailed', $checkout_session));
        }

        header("HTTP/1.1 303 See Other");
        header("Location: " . $checkout_session->url);
        exit;
    }

    public function detail($orderId): View
    {
        $orderData = $this->orderRepository->getById($orderId);
        return view('my_bookings_detail', [
            'pageData' => $orderData,
        ]);
    }

    public function downloadInvoice($orderId): Response
    {
        $orderData = $this->orderRepository->getById($orderId);
        $fileName = 'invoice_' . $orderId . '.pdf';
        $pdf = Pdf::loadView('pdf.invoice.booking', [
            'order' => $orderData,
        ]);

        return $pdf->download($fileName);
    }
}
