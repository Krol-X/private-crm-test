<?php

namespace App\Services;

use App\Interfaces\Services\OrdersServiceInterface;
use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Date;

class OrdersService implements OrdersServiceInterface
{
    /**
     * @return Collection<Order>
     */
    public function getOrders(): Collection
    {
        $orders = Order::all();

        return $orders;
    }

    public function getOrder(int $id)
    {
        $order = Order::find($id);

        return $order;
    }

    public function addOrder(array $fields)
    {
        $order = new Order($fields);
        $order["created_at"] = Date::now();
        $order->save();

        return $order;
    }
}
