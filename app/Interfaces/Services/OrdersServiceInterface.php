<?php

namespace App\Interfaces\Services;

interface OrdersServiceInterface
{
    function getOrders();
    function getOrder(int $id);
    function addOrder(array $fields);
}
