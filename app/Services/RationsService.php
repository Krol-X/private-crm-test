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
     * @return Collection<Ration>
     */
    public function getRations(): Collection
    {
        $rations = Ration::all();

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
        $date = Date::fromSerialized($fields['date']);
        $cooking_day_before = $fields['cooking_day_before'];
        $ration['cooking_date'] = $cooking_day_before ? $date->subDay() : $date;
        $ration['delivery_date'] = $date;
        $ration->save();

        return $ration;
    }

    public function addRations(array $fields): void
    {
        $order = $this->orders->getOrder($fields['order_id']);
        if (!$order) {
            return;
        }
        $cooking_day_before = $order->tariff()['cooking_day_before'];
        $first_date = Date::fromSerialized($fields['first_date']);
        $last_date = Date::fromSerialized($fields['last_date']);
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

            for ($date = $first_date; $date <= $last_date; $date = $date->addDay()) {
                $this->addRation([
                    'order_id' => $fields['order_id'],
                    'date' => $is_tomorrow ? $date->subDay() : $date,
                    'cooking_day_before' => $cooking_day_before
                ]);

                $is_tomorrow = !$is_tomorrow;
            }
        }
    }
}
