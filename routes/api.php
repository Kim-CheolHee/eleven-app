<?php

use App\Http\Controllers\Api\SafeKoicaController;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('safe-koica')->group(function () {
    Route::get('{iso}', [SafeKoicaController::class, 'getCountrySafety']);

    Route::post('install-log', function (Request $request) {
        Log::info('📲 SafeKoica 설치 기록', [
            'event' => $request->input('event'),
            'time' => $request->input('time'),
            'ip' => $request->ip(),
            'agent' => $request->userAgent(),
        ]);

        return response()->json(['status' => 'ok']);
    });

    // 1분에 3회 제한 (IP 기준)
    Route::post('ask', [SafeKoicaController::class, 'askGPT'])
        ->middleware('throttle:3,1');
});

