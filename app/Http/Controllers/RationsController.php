<?php

namespace App\Http\Controllers;

use App\Exceptions\ServerError;
use App\Http\Requests\RationsIndexRequest;
use App\Http\Resources\RationCollection;
use App\Http\Resources\RationResource;
use App\Interfaces\Services\RationsServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RationsController extends Controller
{
    private RationsServiceInterface $rations;

    function __construct(
        RationsServiceInterface $rations_service
    )
    {
        $this->rations = $rations_service;
    }

    function index(RationsIndexRequest $request): JsonResponse
    {
        $fields = collect($request->validated());
        $rations = $this->rations->getRations($fields->get('order_id', null));

        return response()->json(new RationCollection($rations));
    }

    /**
     * @throws ServerError
     */
    function show(Request $request, $ration_id): JsonResponse
    {
        $ration = $this->rations->getRation($ration_id);

        if ($ration !== null) {
            return response()->json([
                'data' => new RationResource($ration)
            ]);
        } else {
            throw new ServerError('The requested ration was not found', 404);
        }
    }
}
