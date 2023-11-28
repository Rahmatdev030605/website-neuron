<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('ALTER TABLE products AUTO_INCREMENT=1');

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('products')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('products')->insert([
            [
                'name' => 'DOOR HRMIS',
                'link' => 'https://doorhrm.com/',
                'desc' => "Elevate your brand's message with dynamic videos, graphics, and animations, bringing stories to life.",
                'image' => 'img/product/door_hrmis.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'MATRIS',
                'link' => null,
                'desc' => 'Streamline operations and foster deeper customer relationships with our tailored CRM solutions.',
                'image' => 'img/product/matris.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'SUSTERS',
                'link' => null,
                'desc' => "Elevate your brand's message with dynamic videos, graphics, and animations, bringing stories to life.",
                'image' => 'img/product/susters.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'SMS MERDEKA',
                'link' => null,
                'desc' => 'Streamline operations and foster deeper customer relationships with our tailored CRM solutions.',
                'image' => 'img/product/sms_merdeka.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'ISSUKU',
                'link' => null,
                'desc' => "Elevate your brand's message with dynamic videos, graphics, and animations, bringing stories to life.",
                'image' => 'img/product/issuku.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'NEMO',
                'link' => null,
                'desc' => 'Streamline operations and foster deeper customer relationships with our tailored CRM solutions.',
                'image' => 'img/product/nemo.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
