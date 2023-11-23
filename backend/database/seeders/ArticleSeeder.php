<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Article;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('ALTER TABLE articles AUTO_INCREMENT=1');

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('articles')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('articles')->insert([
            [
                'title' => 'How to Install Windows 11',
                'image' => 'img/blog/art_1.jpg',
                'desc' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna',
                'body' => 'August 12, 2023',
                'author' => 'Tutorial',
                'user_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Parts of a Microsoft Loop',
                'image' => 'img/blog/art_2.jpg',
                'desc' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna',
                'body' => 'August 12, 2023',
                'author' => 'Sharing Knowledge',
                'user_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Use Case Apache Airflow',
                'image' => 'img/blog/art_3.jpg',
                'desc' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna',
                'body' => 'August 12, 2023',
                'author' => 'Tips',
                'user_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Reacibility Requirement Matrix',
                'image' => 'img/blog/art_4.jpg',
                'desc' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna',
                'body' => 'August 12, 2023',
                'author' => 'Tips',
                'user_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => '8 Principle UI Design',
                'image' => 'img/blog/art_5.jpg',
                'desc' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna',
                'body' => 'August 12, 2023',
                'author' => 'Sharing Knowledge',
                'user_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => '3 Key Learning First Time Leader',
                'image' => 'img/blog/art_6.jpg',
                'desc' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna',
                'body' => 'August 12, 2023',
                'author' => 'Sharing Knowledge',
                'user_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Kerja di Cafe (KeCe)',
                'image' => 'img/blog/art_7.jpg',
                'desc' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna',
                'body' => 'August 12, 2023',
                'author' => 'Tips',
                'user_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'CSS Framework',
                'image' => 'img/blog/art_8.png',
                'desc' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna',
                'body' => 'August 12, 2023',
                'author' => 'Event',
                'user_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Employee Salary Solution',
                'image' => 'img/blog/art_9.jpg',
                'desc' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna',
                'body' => 'August 12, 2023/',
                'author' => 'Sharing Knowledge',
                'user_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
        // \App\Models\Article::factory(10)->create();
    }
}
