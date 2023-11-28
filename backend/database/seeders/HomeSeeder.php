<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('ALTER TABLE home AUTO_INCREMENT=1');

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('home')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('home')->insert([
            'hero_image' => url('/img/home/hero_image.jpg'),
            'about_desc' => 'Neuronworks Indonesia is a company that moving on information technology sector. We are specialize in developing end-to-end solutions to empowering other company effectively navigate to dynamic business challenges. By today we have successfully managed over 1000+ local and international IT projects, including most popular international ventures such as Telkomcel Timor Leste and Telin Malaysia.',
            'about_title'=> 'About',
            'service_title'=> 'Our Services',
            'service_desc' => 'We are try to make everything possible and enhance your business through information technology solutions.',
            'partner_title' => 'Trusted by',
            'partner_desc' => 'We are dedicated to provide a strategic and highly effecient solutions for our customer, each of solutions meticulously crafted by professional and trusted talent.',
            'article_title' => 'Article',
            'article_desc' => 'An update from Neuronworks Indonesia activities',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
