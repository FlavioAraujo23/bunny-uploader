<?php

use App\Exceptions\BunnyApiException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->report(function (BunnyApiException $e, Request $request) {
            Log::channel('bunny')->error($e->getMessage(), [
                'status_code' => $e->getStatusCode(),
                'context' => $e->getContext()
            ]);
        });
        $exceptions->render(function (BunnyApiException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json(['error' => $e->getMessage(), 'status_code' => $e->getStatusCode()], $e->getStatusCode());
            }

            return redirect()->back()->with('error', 'Erro ao comunicar com o bunny: ' . $e->getMessage());
        });
    })->create();