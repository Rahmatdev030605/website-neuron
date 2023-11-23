<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('ALTER TABLE about AUTO_INCREMENT=1');

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('about')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('about')->insert([

            'about_title' => 'Neuron Works',
            'about_desc' => 'Neuron Works',
            'hero_title' => 'Transform Your Idea Into Best Product Digital Solutions',
            'hero_image' => 'http://127.0.0.1:8000/img/about/hero_image.jpg',
            'vision_title' => 'Our Vision',
            'vision_desc' => 'Improving customer performance by making improvements. Improvements and progress in all corners of the customers business processes through superior and best IT solutions.',
            'vision_image' => 'http://127.0.0.1:8000/img/about/vission_image.jpg',
            'value_title' => 'Our Values',
            'value_subtitle' => 'Foundation of Our Core Values',
            'partnership_title' => 'Neuron Works',
            'part_cert_title' => 'Neuron Works',
            'part_cert_desc' => 'Neuron Works',
            'certification_title' => 'Neuron Works',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
