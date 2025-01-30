<?php

namespace App\Http\Controllers;

use App\Interfaces\Services\RationsServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class RationsController extends Controller
{
    private RationsServiceInterface $rations;

    function __construct(
        RationsServiceInterface $rations_service
    )
    {
        $this->rations = $rations_service;
    }

    function index(Request $request): JsonResponse
    {
        $data = Validator::make($request->all(), [
            'order_id' => 'nullable|integer|exists:orders,id',
        ]);

        if ($data->fails()) {
            return response()->json(['error' => $data->errors()], 400);
        }

        $fields = collect($data->validated());
        $rations = $this->rations->getRations($fields->get('order_id', null));

        if ($rations !== null) {
            return Response::json([
                'data' => $rations,
            ]);
        } else {
            return Response::json(
                ['error' => 'The requested order was not found'], 404
            );
        }
    }

    function show(Request $request, $ration_id): JsonResponse
    {
        $ration = $this->rations->getRation($ration_id);

        if ($ration !== null) {
            return Response::json([
                'data' => $ration,
            ]);
        } else {
            return Response::json(
                ['error' => 'The requested ration was not found'], 404
            );
        }
    }
}
