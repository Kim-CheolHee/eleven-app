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

        foreach (range(1, 20) as $index) {
            DB::table('posts')->insert([
                'author' => $faker->name,
                'password' => str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT), // 4자리 숫자 비밀번호
                'title' => $faker->sentence(4),
                'content' => $faker->paragraph(3),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
