<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $fileExtensions = ['jpg', 'png', 'pdf', 'mp4']; // 첨부파일 확장자 목록

        foreach (range(1, 20) as $index) {
            $hasFile = rand(0, 1); // 50% 확률로 첨부파일 추가
            $filePath = $hasFile ? 'uploads/' . $faker->uuid . '.' . $faker->randomElement($fileExtensions) : null;

            DB::table('posts')->insert([
                'author' => $faker->name,
                'password' => str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT), // 4자리 숫자 비밀번호
                'title' => $faker->sentence(4),
                'content' => $faker->paragraph(3),
                'file_path' => $filePath,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
