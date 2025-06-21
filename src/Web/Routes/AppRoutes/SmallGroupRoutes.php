<?php

use Illuminate\Support\Facades\Route;
use App\Web\Controllers\SmallGroupController;

Route::prefix('small-group')->group(function () {
    Route::post('/', [SmallGroupController::class, 'create']);
    Route::patch('/', [SmallGroupController::class, 'update']);
    
    Route::get('/list', [SmallGroupController::class, 'getList']);

    Route::post('/add-member', [SmallGroupController::class, 'addMember']);
});