<?php

namespace App\Http\Controllers;

use App\Interfaces\Services\OrdersServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class OrdersController extends Controller
{
    private OrdersServiceInterface $orders;

    function __construct(OrdersServiceInterface $orders_service)
    {
        $this->orders = $orders_service;
    }

    function index(Request $request)
    {
        return Inertia::render('Orders', [
            'orders' => $this->orders->getOrders(),
        ]);
    }

    function store(Request $request)
    {
        $data = Validator::make($request->all(), [
            'client_name' => 'string|required',
            'client_phone' => 'string|size:11|required',
            'tariff_id' => 'integer|required|exists:tariffs,id',
            'schedule_type' => 'in:EVERY_DAY,EVERY_OTHER_DAY,EVERY_OTHER_DAY_TWICE|required',
            'comment' => 'string|required',
            'first_date' => 'date|required',
            'last_date' => 'date|required',
        ]);

        if ($data->fails()) {
            return response()->json(['error' => $data->errors()], 400);
        }

        $order = $this->orders->addOrder($data->validated());
        return Response::json($order);
    }

    function show(Request $request, $order_id)
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
