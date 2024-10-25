<?php

use App\Exceptions\Api\V1\ApiExceptions;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            // API Version 1 routes
            Route::middleware('api')
                ->prefix('api/v1')
                ->group(base_path('routes/api_v1.php'));
        }

    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // https://laravel-news.com/always-render-api-exceptions-as-json-in-laravel
        // $exceptions->shouldRenderJsonWhen(function (Request $request, Throwable $e) {
        //     if ($request->is('api/*')) {
        //         return true;
        //     }
        //     return $request->expectsJson();
        // });

        $exceptions->render(function (Throwable $e, Request $request) {
            if ($request->wantsJson()) {
                $className = get_class($e);
                $handlers = ApiExceptions::$handlers;

                if (array_key_exists($className, $handlers)) {
                    $method = $handlers[$className];
                    return ApiExceptions::$method($e, $request);
                }

                return response()->json([
                    'error' => [
                        'type' => basename(get_class($e)), 'status' => intval($e->getCode()), // returns 0 if no code
                        'message' => $e->getMessage()
                    ]
                ]);
            }

            throw $e;
        });

    })->create();
