<?php

use Illuminate\Support\Facades\Route;
use App\Web\Controllers\PersonController;

Route::post('/person', [PersonController::class, 'save']);

//Route::get('/ping', fn () => response()->json(['ok' => true]));