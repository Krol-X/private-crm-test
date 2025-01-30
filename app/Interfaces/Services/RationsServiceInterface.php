<?php

namespace App\Interfaces\Services;

interface RationsServiceInterface
{
    function __construct(OrdersServiceInterface $orders_service);
    function getRations();
    function getRation(int $id);
    function addRation(array $fields);
    function addRations(array $fields);
}
