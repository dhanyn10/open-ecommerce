<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use App\Http\Middleware\Admin;
use App\Http\Middleware\Penjual;
use App\Http\Middleware\Pembeli;
use App\Http\Middleware\Pengguna;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => Admin::class,
            'penjual' => Penjual::class,
            'pembeli' => Pembeli::class,
            'pengguna' => Pengguna::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
