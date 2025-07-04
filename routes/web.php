<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\MemoryGameController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Models\Announcement;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// 홈페이지 라우트
Route::get('/', function () {
    $notices = Announcement::where('is_visible', true)->latest()->take(5)->get();

    return Inertia::render('Welcome', [
        'koica164Time' => Route::has('koica164Time'),
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'notices' => $notices, // 공지사항 데이터 전달
    ]);
})->name('welcome');

// 관리자 페이지 라우트
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/info', function () { return Inertia::render('Info'); })->name('info');
    Route::get('/laos', function () { return Inertia::render('Laos'); })->name('laos');

    Route::get('/announcement', [AnnouncementController::class, 'index'])->name('announcement.index');
    Route::get('/announcement/{id}', [AnnouncementController::class, 'show'])->name('announcement.show');
    Route::post('/announcement', [AnnouncementController::class, 'store'])->name('announcement.store');
    Route::patch('/announcement/{id}', [AnnouncementController::class, 'update'])->name('announcement.update');
    Route::delete('/announcement/{id}', [AnnouncementController::class, 'destroy'])->name('announcement.destroy');
});

// 대시보드 라우트
Route::get('/dashboard', function () { return Inertia::render('Dashboard'); })->middleware(['auth', 'verified'])->name('dashboard');

// 게시판 ID별로 하나의 라우트로 관리 (동적 라우트)
Route::get('/class/{class_id}', [PostController::class, 'index'])->where('class_id', '[1-4]')->name('class.board');
Route::post('/class/{class_id}/store', [PostController::class, 'store'])->where('class_id', '[1-4]')->name('class.board.store');
Route::delete('/class/{class_id}/{post_id}', [PostController::class, 'destroy'])->where(['class_id' => '[1-4]', 'post_id' => '[0-9]+'])->name('class.board.destroy');
Route::patch('/class/{class_id}/{post_id}', [PostController::class, 'update'])->where(['class_id' => '[1-4]', 'post_id' => '[0-9]+'])->name('class.board.update');

// Play 페이지 (심리테스트, MBTI 등)
Route::get('/play', function () { return Inertia::render('Play');})->name('play');
Route::get('/memory-game', [MemoryGameController::class, 'index'])->name('memory_game');
Route::post('/memory-game/store', [MemoryGameController::class, 'store'])->name('memory_game.store');

Route::get('/bingo', function () { return Inertia::render('Games/Bingo'); })->name('bingo');

Route::get('/number-guess', function () { return Inertia::render('Games/NumberGuess'); })->name('number_guess');
Route::get('/mbti-test', function () { return Inertia::render('Tests/MBTITest'); })->name('mbti_test');
Route::get('/color-match', function () { return Inertia::render('Games/ColorMatch'); })->name('color_match');

// 학습 관련 라우트
Route::get('/study', function () { return Inertia::render('Study');})->name('study');



// koica 시간 라우트
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
    return Inertia::render('koica164Time', [ 'koica164Times' => $times->values()->toArray() ]);
})->name('koica164_time');

// Privacy 페이지 라우트 추가
Route::get('/privacy-eu', function () { return Inertia::render('Privacy/PrivacyEU'); })->name('privacy.eu');
Route::get('/privacy-us', function () { return Inertia::render('Privacy/PrivacyUS'); })->name('privacy.us');
Route::get('/privacy-kr', function () { return Inertia::render('Privacy/PrivacyKR'); })->name('privacy.kr');

// Safe KOICA 페이지 라우트 추가
// Route::get('/safe-koica', function () {
//     return Inertia::render('SafeKoica');
// })->name('safe_koica');

require __DIR__.'/auth.php';
