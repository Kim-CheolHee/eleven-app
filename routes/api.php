<?php

use App\Http\Controllers\Api\SafeKoicaController;
use Illuminate\Support\Facades\Route;

Route::get('/safe-koica/{iso}', [SafeKoicaController::class, 'getCountrySafety']);
