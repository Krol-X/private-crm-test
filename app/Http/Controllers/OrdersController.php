<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrdersStoreRequest;
use App\Interfaces\Services\OrdersServiceInterface;
use App\Interfaces\Services\RationsServiceInterface;
use App\Interfaces\Services\TariffsServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;

class OrdersController extends Controller
{
    private OrdersServiceInterface $orders;
    private TariffsServiceInterface $tariffs;
    private RationsServiceInterface $rations;

    function __construct(
        OrdersServiceInterface  $orders_service,
        TariffsServiceInterface $tariffs_service,
        RationsServiceInterface $rations_service
    )
    {
        $this->orders = $orders_service;
        $this->tariffs = $tariffs_service;
        $this->rations = $rations_service;
    }

    function index(Request $request): \Inertia\Response
    {
        return Inertia::render('Orders', [
            'orders' => $this->orders->getOrders(),
            'tariffs' => $this->tariffs->getTariffs()
        ]);
    }

    function store(OrdersStoreRequest $request): JsonResponse
    {
        $fields = $request->validated();
        $order = $this->orders->addOrder($fields);

        $this->rations->addRations([
            'order_id' => $order->id,
            'schedule_type' => $fields['schedule_type'],
            'first_date' => $fields['first_date'],
            'last_date' => $fields['last_date'],
        ]);

        return Response::json($order);
    }

    function show(Request $request, $order_id): JsonResponse
    {
        $order = $this->orders->getOrder($order_id);

        if ($order !== null) {
            return Response::json([
                'data' => $order,
            ]);
        } else {
            return Response::json(
                ['error' => 'The requested order was not found'], 404
            );
        }
    }
}
