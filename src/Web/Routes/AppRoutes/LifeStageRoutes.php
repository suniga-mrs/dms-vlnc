<?php

use Illuminate\Support\Facades\Route;
use App\Web\Controllers\LifeStageController;


Route::prefix('life-stage')->group(function () {
    Route::post('/', [LifeStageController::class, 'save']);
    Route::get('/list', [LifeStageController::class, 'all']);
});