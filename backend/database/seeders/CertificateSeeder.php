<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CertificateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('ALTER TABLE certificate AUTO_INCREMENT=1');

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('certificate')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('certificate')->insert([
            [
                'title' => 'AWS Certified Solutions Architect',
                'company' => 'Amazon Web Services',
                'image' => 'img/certificate/certificate-1.png',
                'about_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Microsoft Azure Solutions Architect',
                'company' => 'Microsoft Azure ',
                'image' => 'img/certificate/certificate-3.png',
                'about_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Oracle Database Administrator',
                'company' => 'Oracle ',
                'image' => 'img/certificate/certificate-2.png',
                'about_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Oracle Database Administrator',
                'company' => 'Oracle ',
                'image' => 'img/certificate/certificate-2.png',
                'about_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
