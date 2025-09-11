<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\KasirMiddleware;
use App\Http\Middleware\LoginMiddleware;
use App\Http\Middleware\RolePermissionMiddleware;
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
        // clockwork
        $middleware->append(\Clockwork\Support\Laravel\ClockworkMiddleware::class);
        $middleware->alias([
            'admin' => AdminMiddleware::class,
            'loginPage' => LoginMiddleware::class,
            'kasir' => KasirMiddleware::class,
            'role' => RolePermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
