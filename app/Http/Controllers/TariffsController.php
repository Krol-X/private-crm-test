<?php

namespace App\Http\Controllers;

use App\Exceptions\ServerError;
use App\Http\Requests\TariffsStoreRequest;
use App\Http\Requests\TariffsUpdateRequest;
use App\Http\Resources\TariffCollection;
use App\Http\Resources\TariffResource;
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
            'tariffs' => new TariffCollection($this->tariffs->getTariffs()),
        ]);
    }

    function store(TariffsStoreRequest $request): TariffResource|JsonResponse
    {
        $tariff = $this->tariffs->addTariff($request->validated());

        return response()->json(new TariffResource($tariff));
    }

    /**
     * @throws ServerError
     */
    function show(Request $request, $tariff_id): TariffResource|JsonResponse
    {
        $tariff = $this->tariffs->getTariff($tariff_id);

        if ($tariff !== null) {
            return response()->json([
                'data' => new TariffResource($tariff)
            ]);
        } else {
            throw new ServerError('The requested tariff was not found', 404);
        }
    }

    /**
     * @throws ServerError
     */
    function update(TariffsUpdateRequest $request, $tariff_id): TariffResource|JsonResponse
    {
        $tariff = $this->tariffs->updateTariff($tariff_id, $request->validated());

        if (!$tariff) {
            throw new ServerError('The requested tariff was not found', 404);
        }

        return new TariffResource($tariff);
    }

    function destroy(Request $request, $tariff_id): JsonResponse
    {
        $this->tariffs->removeTariff($tariff_id);

        return Response::json([], 204);
    }
}
