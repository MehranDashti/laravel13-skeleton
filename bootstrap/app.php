<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Middleware\JsonMiddleware;
use App\Http\Middleware\RequestLoggerMiddleware;
use Mehrand\ApiExceptions\Handlers\ApiException;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        using: function () {
            Route::middleware(['api', JsonMiddleware::class, RequestLoggerMiddleware::class, SubstituteBindings::class])
                ->prefix('api/v1')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        },
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Throwable $e, Request $request) {
            if ($e instanceof RouteNotFoundException || str_contains($e->getMessage(), '[login]')) {
                Throw new RuntimeException(trans('messages.user_is_unauthenticated'), Response::HTTP_UNAUTHORIZED);
            }
            if ($e instanceof UnauthorizedHttpException) {
                Throw new RuntimeException(trans('messages.user_is_unauthenticated'), Response::HTTP_UNAUTHORIZED);
            }

            return ApiException::handle($e);
        });
    })->create();
