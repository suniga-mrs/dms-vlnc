<?php

use Illuminate\Support\Facades\Route;
use App\Web\Controllers\LifeStageController;


Route::prefix('life-stage')->group(function () {
    Route::post('/', [LifeStageController::class, 'save']);
    Route::delete('/', [LifeStageController::class, 'delete']);
    Route::get('/list', [LifeStageController::class, 'all']);
});