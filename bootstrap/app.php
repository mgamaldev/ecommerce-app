<?php

use App\Exceptions\ApiBaseException;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Log;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->report(function (ApiBaseException $e) {
            Log::channel($e->logChannel())->warning(
                class_basename($e),
                array_merge(
                    [
                        'message' => $e->getMessage(),
                        'code' => $e->errorCode(),
                        'user_id' => auth()->id(),
                        'ip' => request()->ip(),
                    ],
                    $e->context()
                )
            );
        });
        $exceptions->render(function (ApiBaseException $e) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $e->getMessage(),
                    'errors' => null,
                ], $e->status()
            );

        });
    })
    ->withSchedule(function (Schedule $schedule): void {
        $schedule->command('carts:clear-abandoned')->daily();
    })->create();
