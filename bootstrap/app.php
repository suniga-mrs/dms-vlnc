<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api:        __DIR__.'/../src/ConnectApp.Web/Routes/api.php',
        commands:   __DIR__.'/../src/ConnectApp.Web/Routes/console.php',
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
    __DIR__ . '/../src/ConnectApp.Application/Config'
);

// Override the bootstrap (cache) path
$app->useBootstrapPath(
    __DIR__ . '/../src/ConnectApp.Application/Bootstrap'
);
    

return $app;
