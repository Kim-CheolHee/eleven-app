<?php

use App\Http\Controllers\Api\SafeKoicaController;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/safe-koica/{iso}', [SafeKoicaController::class, 'getCountrySafety']);

Route::post('/safe-koica/install-log', function (Request $request) {
    Log::info('📲 SafeKoica 설치 기록', [
        'event' => $request->input('event'),
        'time' => $request->input('time'),
        'ip' => $request->ip(),
        'agent' => $request->userAgent(),
    ]);

    return response()->json(['status' => 'ok']);
});
