<?php

namespace App\Services\Admin;

use App\Models\Order;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class OrderService
{
    public function getAllOrders($request = null, int $perPage = 10): LengthAwarePaginator
    {
        return $orders = Order::Filter($request)->paginate($perPage);
    }

    public function getOrder(int $id): Order
    {
        return $order = Order::findOrFail($id);
    }

    public function updateOrder(int $id, array $data): Order
    {
        $order = Order::findOrFail($id);
        $order->update([
            'payment_status' => 'refunded',
        ]);

        return $order;
    }
}
