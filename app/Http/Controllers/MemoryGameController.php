<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MemoryGameScore;
use Inertia\Inertia;

class MemoryGameController extends Controller
{
    // 기록 불러오기
    public function index()
    {
        $scores = MemoryGameScore::orderBy('time')->orderBy('moves')->take(10)->get();
        return Inertia::render('Games/MemoryGame', ['scores' => $scores]);
    }

    // 기록 저장
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'time' => 'required|integer|min:1',
            'moves' => 'required|integer|min:1',
        ]);

        MemoryGameScore::create($validated);

        return redirect()->route('memory_game'); // 저장 후 다시 불러오기
    }
}
