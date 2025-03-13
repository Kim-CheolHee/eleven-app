<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('memory_game_scores', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // 플레이어 이름
            $table->integer('time'); // 클리어 시간 (초)
            $table->integer('moves'); // 시도 횟수
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memory_game_scores');
    }
};
