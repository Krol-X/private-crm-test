<?php

use App\Http\Controllers\OrdersController;
use App\Http\Controllers\RationsController;
use App\Http\Controllers\TariffsController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home', []);
});

Route::resource('/orders', OrdersController::class)->only([
    'index', // inertia
    // 'create',
    'store',
    'show',
    // 'edit',
    // 'update',
    // 'destroy',
]);

Route::resource('/tariffs', TariffsController::class)->only([
    'index', // inertia
    // 'create',
    'store',
    'show',
    // 'edit',
    'update',
    'destroy',
]);

Route::resource('/rations', RationsController::class)->only([
    'index',
    // 'create',
    // 'store',
    'show',
    // 'edit',
    // 'update',
    // 'destroy',
]);
