<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'isCustomer' => App\Http\Middleware\IsCustomer::class,
            'isAdmin'    => App\Http\Middleware\IsAdmin::class,
            'isPenjual'  => App\Http\Middleware\IsPenjual::class,
            'isDriver'   => App\Http\Middleware\IsDriver::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();