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
    public function getOrders($trashed_tariffs = true): Collection
    {
        if ($trashed_tariffs) {
            $orders = Order::with(['tariff' => function ($query) {
                $query->withTrashed();
            }])->get();
        } else {
            $orders = Order::with('tariff')->get();
        }

        return $orders;
    }

    public function getOrder(int $id, $trashed_tariffs = true): ?Order
    {
        if ($trashed_tariffs) {
            $order = Order::with(['tariff' => function ($query) {
                $query->withTrashed();
            }])->find($id);
        } else {
            $order = Order::with('tariff')->find($id);
        }

        return $order;
    }

    public function addOrder(array $fields): Order
    {
        $order = new Order($fields);
        $order["created_at"] = Date::now();
        $order->save();

        return $order;
    }
}
