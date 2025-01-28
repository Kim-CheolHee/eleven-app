<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'koica164Time' => Route::has('koica164Time'),
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/koica164-time', function () {
    $timezones = [
        '대한민국' => 'Asia/Seoul',
        '필리핀' => 'Asia/Manila',
        '베트남/라오스/태국' => 'Asia/Ho_Chi_Minh',
        '방글라데시/키르기스스탄' => 'Asia/Dhaka',
        '네팔' => 'Asia/Kathmandu',
        '우간다/탄자니아' => 'Africa/Kampala',
        '르완다' => 'Africa/Kigali',
        '튀니지/카메룬' => 'Africa/Tunis',
        '가나/세네갈' => 'Africa/Accra',
        '볼리비아/도미니카공화국' => 'America/La_Paz',
        '페루/콜롬비아' => 'America/Bogota',
    ];

    $times = collect($timezones)->map(function ($timezone, $country) {
        return [
            'country' => $country,
            'time' => now()->setTimezone($timezone)->format('Y-m-d H:i:s'),
        ];
    });

    return Inertia::render('koica164Time', [
        'koica164Times' => $times->values()->toArray(), // 배열로 변환
    ]);
})->name('koica164_time');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/info', function () {
        return Inertia::render('Info');
    })->name('info');
});

require __DIR__.'/auth.php';
