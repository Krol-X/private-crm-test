<?php

use App\Http\Controllers\OrdersController;
use App\Http\Controllers\RationsController;
use App\Http\Controllers\TariffsController;
use Illuminate\Support\Facades\Route;

Route::resource('/orders', OrdersController::class)
    ->parameter('orders', 'order_id')
    ->only([
        'index', // inertia
        // 'create',
        'store',
        'show',
        // 'edit',
        // 'update',
        // 'destroy',
    ])->names([
        'index' => 'orders.index',
        'store' => 'orders.store',
        'show' => 'orders.show',
    ]);

Route::resource('/tariffs', TariffsController::class)
    ->parameter('tariffs', 'tariff_id')
    ->only([
        'index', // inertia
        // 'create',
        'store',
        'show',
        // 'edit',
        'update',
        'destroy',
    ])->names([
        'index' => 'tariffs.index',
        'store' => 'tariffs.store',
        'show' => 'tariffs.show',
        'update' => 'tariffs.update',
        'destroy' => 'tariffs.destroy',
    ]);

Route::resource('/rations', RationsController::class)
    ->parameter('rations', 'ration_id')
    ->only([
        'index',
        // 'create',
        // 'store',
        'show',
        // 'edit',
        // 'update',
        // 'destroy',
    ])->names([
        'index' => 'rations.index',
        'show' => 'rations.show',
    ]);
