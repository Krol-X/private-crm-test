<?php

namespace App\Services;

use App\Interfaces\Services\OrdersServiceInterface;
use App\Interfaces\Services\RationsServiceInterface;
use App\Models\Ration;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Date;

class RationsService implements RationsServiceInterface
{
    private OrdersServiceInterface $orders;

    function __construct(
        OrdersServiceInterface $orders_service
    )
    {
        $this->orders = $orders_service;
    }

    /**
     * @return ?Collection<Ration>
     */
    public function getRations(int $order_id = null): ?Collection
    {
        $rations = null;

        if ($order_id) {
            $order = $this->orders->getOrder($order_id);

            if ($order) {
                $rations = $order->rations;
            }
        } else {
            $rations = Ration::all();
        }

        return $rations;
    }

    public function getRation(int $id): ?Ration
    {
        $ration = Ration::find($id);

        return $ration;
    }

    public function addRation(array $fields): Ration
    {
        $ration = new Ration();

        $ration['order_id'] = $fields['order_id'];
        $date = Date::parse($fields['date']);
        $cooking_day_before = $fields['cooking_day_before'];
        $ration['cooking_day_before'] = $cooking_day_before;
        $ration['delivery_date'] = $date;
        $ration['cooking_date'] = $cooking_day_before ? $date->copy()->subDay() : $date;
        $ration->save();

        return $ration;
    }

    public function addRations(array $fields): void
    {
        $order = $this->orders->getOrder($fields['order_id']);
        if (!$order) {
            return;
        }
        $cooking_day_before = $order->tariff->cooking_day_before;
        $first_date = Date::parse($fields['first_date']);
        $last_date = Date::parse($fields['last_date']);
        $schedule_type = $order['schedule_type'];

        if ($schedule_type == 'EVERY_DAY') {
            for ($date = $first_date; $date <= $last_date; $date = $date->addDay()) {
                $this->addRation([
                    'order_id' => $fields['order_id'],
                    'date' => $date,
                    'cooking_day_before' => $cooking_day_before
                ]);
            }
        } else if ($schedule_type == 'EVERY_OTHER_DAY') {
            for ($date = $first_date; $date <= $last_date; $date = $date->addDays(2)) {
                $this->addRation([
                    'order_id' => $fields['order_id'],
                    'date' => $date,
                    'cooking_day_before' => $cooking_day_before
                ]);
            }
        } else if ($schedule_type == 'EVERY_OTHER_DAY_TWICE') {
            $is_tomorrow = false;

            for ($current = $first_date->copy(); $first_date <= $last_date; $first_date->addDay()) {
                $this->addRation([
                    'order_id' => $fields['order_id'],
                    'date' => $current,
                    'cooking_day_before' => $cooking_day_before
                ]);

                $is_tomorrow = !$is_tomorrow;

                if (!$is_tomorrow) {
                    $current->addDays(2);
                }
            }
        }
    }
}
