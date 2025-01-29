<?php

namespace App\Http\Controllers;

use App\Interfaces\Services\TariffsServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class TariffsController extends Controller
{
    private TariffsServiceInterface $tariffs;

    function __construct(TariffsServiceInterface $tariffs_service)
    {
        $this->tariffs = $tariffs_service;
    }

    function index(Request $request): \Inertia\Response
    {
        return Inertia::render('Tariffs', [
            'tariffs' => $this->tariffs->getTariffs(),
        ]);
    }

    function store(Request $request): JsonResponse
    {
        $data = Validator::make($request->all(), [
            'ration_name' => 'string|required',
            'cooking_day_before' => 'boolean|required',
        ]);

        if ($data->fails()) {
            return response()->json(['error' => $data->errors()], 400);
        }

        $tariff = $this->tariffs->addTariff($data->validated());
        return Response::json($tariff);
    }

    function show(Request $request, $tariff_id): JsonResponse
    {
        $tariff = $this->tariffs->getTariff($tariff_id);

        if ($tariff !== null) {
            return Response::json([
                'data' => $tariff,
            ]);
        } else {
            return Response::json(
                ['error' => 'The requested tariff was not found'], 404
            );
        }
    }

    function update(Request $request, $tariff_id): JsonResponse
    {
        $data = Validator::make($request->all(), [
            'ration_name' => 'string|optional',
            'cooking_day_before' => 'boolean|optional',
        ]);

        if ($data->fails()) {
            return response()->json(['error' => $data->errors()], 400);
        }

        $tariff = $this->tariffs->updateTariff($tariff_id, $data->validated());

        if (!$tariff) {
            return Response::json(
                ['error' => 'The requested tariff was not found'], 404
            );
        }

        return Response::json([
            'data' => $tariff,
        ]);
    }

    function delete(Request $request, $tariff_id): JsonResponse
    {
        $this->tariffs->removeTariff($tariff_id);

        return Response::json([], 204);
    }
}
