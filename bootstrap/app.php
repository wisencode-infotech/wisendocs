<?php

use App\Http\Middleware\CheckRole;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware(['web'])
                ->prefix('backend')
                ->name('backend.')
                ->namespace('App\\Http\\Controllers\\Backend')
                ->group(base_path('routes/backend.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'check.role' => CheckRole::class,
        ]);

        $middleware->redirectGuestsTo(fn (Request $request) => route('backend.login'));
        $middleware->redirectUsersTo(fn (Request $request) => route('backend.home'));
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
