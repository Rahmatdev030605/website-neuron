<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ValueListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('ALTER TABLE value_lists AUTO_INCREMENT=1');

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('value_lists')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('value_lists')->insert([
            [
                'title' => 'Satisfied Customer',
                'desc' => ' Serving customers with dedication, prioritizing win-win solutions, and ensuring 24-hour service.',
                'image' => 'img/valuelist/val_img_1.png', //random vall
                'about_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Inovation for Solutions',
                'desc' => 'Serving customers with dedication, prioritizing win-win solutions, and ensuring 24-hour service.',
                'image' => 'img/valuelist/val_img_2.png',
                'about_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Excellent Software',
                'desc' => 'Serving customers with dedication, prioritizing win-win solutions, and ensuring 24-hour service.',
                'image' => 'img/valuelist/val_img_3.png',
                'about_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
