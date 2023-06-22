<?php

namespace App\Repositories\Admin;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\DB;

class OrderRepository
{
    public function getById($id)
    {
        return Order::findOrFail($id);
    }

    public function create(array $data)
    {
        return Order::create($data);
    }

    public function update($id, array $newDetails)
    {
        return Order::whereId($id)->update($newDetails);
    }

    public function updateOrderDetail($id, array $newDetails)
    {
        return OrderDetail::where('order_id', $id)->update($newDetails);
    }

    public function updateOrderDetailWithDetailId($id, array $newDetails)
    {
        return OrderDetail::where('id', $id)->update($newDetails);
    }

    public function delete($id)
    {
        Order::destroy($id);
    }

    public function getPaymentReportData($filterParams = array())
    {
        $ordersQuery = Order::with([
            'orderDetail' => function ($query) {
                return $query->select('id', 'order_id', 'product_strike_price', 'material_charge', 'material_charge_actual', 'material_description', 'additional_charge',	'product_price', 'product_commission', 'created_at', 'updated_at');
            },
            'provider' => function ($query) {
                return $query->select('id', 'name', 'phone');
            }
        ])->where([
            'payment_status' => 'Completed',
            'order_status' =>'completed'
        ]);

        if(! empty($filterParams['order'])) {
            $ordersQuery->where('order_id', $filterParams['order']);
        }

        $ordersData = $ordersQuery->paginate(15);

        return $ordersData;
    }
}
