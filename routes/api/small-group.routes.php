<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SmallGroupController;

Route::post('/small-group', [SmallGroupController::class, 'save']);