<?php

namespace App\Interfaces\Services;

use App\Models\Ration;
use Illuminate\Database\Eloquent\Collection;

interface RationsServiceInterface
{
    function __construct(OrdersServiceInterface $orders_service);
    function getRations(int $order_id = null): ?Collection;
    function getRation(int $id): ?Ration;
    function addRation(array $fields): Ration;
    function addRations(array $fields): void;
}
