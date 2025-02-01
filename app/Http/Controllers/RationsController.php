<?php

namespace App\Http\Controllers;

use App\Http\Requests\RationsIndexRequest;
use App\Http\Resources\RationCollection;
use App\Http\Resources\RationResource;
use App\Interfaces\Services\RationsServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class RationsController extends Controller
{
    private RationsServiceInterface $rations;

    function __construct(
        RationsServiceInterface $rations_service
    )
    {
        $this->rations = $rations_service;
    }

    function index(RationsIndexRequest $request): RationCollection|JsonResponse
    {
        $fields = collect($request->validated());
        $rations = $this->rations->getRations($fields->get('order_id', null));

        if ($rations !== null) {
            return new RationCollection($rations);
        } else {
            return Response::json(
                ['error' => 'The requested order was not found'], 404
            );
        }
    }

    function show(Request $request, $ration_id): RationResource|JsonResponse
    {
        $ration = $this->rations->getRation($ration_id);

        if ($ration !== null) {
            return new RationResource($ration);
        } else {
            return Response::json(
                ['error' => 'The requested ration was not found'], 404
            );
        }
    }
}
