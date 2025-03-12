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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('author'); // 작성자
            $table->string('password', 4); // 4자리 숫자 비밀번호
            $table->string('title'); // 제목
            $table->text('content'); // 내용
            $table->string('file_path')->nullable(); // 첨부파일 경로 추가
            $table->integer('class_id'); // 게시판 구분을 위한 컬럼 추가 (예: 1, 2, 3, 4)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
