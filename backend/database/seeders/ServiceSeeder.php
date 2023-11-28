<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('ALTER TABLE services AUTO_INCREMENT=1');

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('services')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('services')->insert([
            [
                'name' => 'MULTIMEDIA',
                'desc' => 'Highly multimedia content, UI/UX Design, video editing, film and animation, social media management, script writting, Photography, Logo design and visual graphic design for your product.',
                'image' => 'img/service/multiimedia.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'CRM',
                'desc' => 'Customer Relationship Management app help you to improved your customer experience by giving personalized and responsive automation services.',
                'image' => 'img/service/crm.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'SYSTEM INTEGRATOR',
                'desc' => 'Create a seamless integrations within some app effectively, system integrator can enhance efficiency of system communication and minimize the compatibilities issue to saving your cost.',
                'image' => 'img/service/systemIntegrator.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'SYSTEM INTEGRATOR',
                'desc' => 'Create a seamless integrations within some app effectively, system integrator can enhance efficiency of system communication and minimize the compatibilities issue to saving your cost.',
                'image' => 'img/service/systemIntegrator.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'SYSTEM INTEGRATOR',
                'desc' => 'Create a seamless integrations within some app effectively, system integrator can enhance efficiency of system communication and minimize the compatibilities issue to saving your cost.',
                'image' => 'img/service/systemIntegrator.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
