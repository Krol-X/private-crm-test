<?php

namespace App\Providers;

use App\Services\OrdersService;
use App\Services\TariffsService;
use App\Services\RationsService;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('App\Interfaces\Services\OrdersServiceInterface', function ($app) {
            return new OrdersService();
        });
        $this->app->singleton('App\Interfaces\Services\TariffsServiceInterface', function ($app) {
            return new TariffsService();
        });
        $this->app->singleton('App\Interfaces\Services\RationsServiceInterface', function ($app) {
            return new RationsService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
    }
}
