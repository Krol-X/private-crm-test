<?php

use App\Exceptions\ServerError;
use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Resources\ErrorResource;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;
use Illuminate\Http\Request;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Validation\ValidationException;
use Illuminate\View\Middleware\ShareErrorsFromSession;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(
            append: [
                HandleInertiaRequests::class,
                AddLinkHeadersForPreloadedAssets::class,
            ],
            remove: [
                // https://stackoverflow.com/questions/78618910/laravel-11-disable-all-of-the-set-cookie-headers-xcsrf-laravel-session
                StartSession::class,
                ShareErrorsFromSession::class,
                ValidateCsrfToken::class,
            ]
        );
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (ValidationException $th, Request $request) {
            throw new ServerError($th->getMessage(), $th->getCode());
        });

        $exceptions->render(function (ServerError $th, Request $request) {
            return response()->json(new ErrorResource($th), $th->getCode());
        });
    })->create();
