<?php

use Illuminate\Support\Facades\Route;
use App\Web\Controllers\PersonController;

Route::prefix('person')->group(function () {
    Route::post('/', [PersonController::class, 'save']);
    Route::get('/list', [PersonController::class, 'getList']);
});