<?php

namespace App\Http\Controllers;

use App\Http\Requests\TariffsStoreRequest;
use App\Http\Requests\TariffsUpdateRequest;
use App\Interfaces\Services\TariffsServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
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

    function store(TariffsStoreRequest $request): JsonResponse
    {
        $tariff = $this->tariffs->addTariff($request->validated());

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

    function update(TariffsUpdateRequest $request, $tariff_id): JsonResponse
    {
        $tariff = $this->tariffs->updateTariff($tariff_id, $request->validated());

        if (!$tariff) {
            return Response::json(
                ['error' => 'The requested tariff was not found'], 404
            );
        }

        return Response::json([
            'data' => $tariff,
        ]);
    }

    function destroy(Request $request, $tariff_id): JsonResponse
    {
        $this->tariffs->removeTariff($tariff_id);

        return Response::json([], 204);
    }
}
