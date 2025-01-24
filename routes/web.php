<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'worldTime' => Route::has('worldTime'),
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/world-time', function () {
    $timezones = [
        '대한민국' => 'Asia/Seoul',
        '베트남' => 'Asia/Ho_Chi_Minh',
        '네팔' => 'Asia/Kathmandu',
        '튀니지' => 'Africa/Tunis',
        '가나' => 'Africa/Accra',
        '볼리비아' => 'America/La_Paz',
        '콜롬비아' => 'America/Bogota',
    ];

    $times = collect($timezones)->map(function ($timezone, $country) {
        return [
            'country' => $country,
            'time' => now()->setTimezone($timezone)->format('Y-m-d H:i:s'),
        ];
    });

    return Inertia::render('WorldTime', [
        'worldTimes' => $times->values()->toArray(), // 배열로 변환
    ]);
})->name('world_time');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
