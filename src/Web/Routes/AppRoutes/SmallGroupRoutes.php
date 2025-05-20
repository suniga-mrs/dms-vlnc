<?php

use Illuminate\Support\Facades\Route;
use App\Web\Controllers\SmallGroupController;

Route::post('/small-group', [SmallGroupController::class, 'save']);