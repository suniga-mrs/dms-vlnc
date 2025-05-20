<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Application\Providers\EventServiceProvider;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api:        __DIR__.'/../src/Web/Routes/api.php',
        commands:   __DIR__.'/../src/Web/Routes/console.php',
        health:     '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Add global or group middleware here if needed
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Customize exception handling if needed
    })->create();

// Override the default config path
$app->useConfigPath(
    __DIR__ . '/../src/Application/Config'
);    

// Register event provider
$app->register(EventServiceProvider::class);

return $app;
