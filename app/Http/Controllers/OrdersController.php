<?php

namespace App\Http\Controllers;

use App\Exceptions\ServerError;
use App\Http\Requests\OrdersStoreRequest;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Http\Resources\TariffCollection;
use App\Interfaces\Services\OrdersServiceInterface;
use App\Interfaces\Services\RationsServiceInterface;
use App\Interfaces\Services\TariffsServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
            'orders' => new OrderCollection($this->orders->getOrders()),
            'tariffs' => new TariffCollection($this->tariffs->getTariffs())
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

        return response()->json(new OrderResource($order));
    }

    /**
     * @throws ServerError
     */
    function show(Request $request, $order_id): JsonResponse
    {
        $order = $this->orders->getOrder($order_id);

        if ($order !== null) {
            return response()->json([
                'data' => new OrderResource($order),
            ]);
        } else {
            throw new ServerError('The requested order was not found', 404);
        }
    }
}
