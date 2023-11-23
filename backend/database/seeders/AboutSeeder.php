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

            'hero_title' => 'ABOUT NEURON',
            'hero_image' => 'img/about/hero_img.jpg',
            'about_title' => 'Neuron partners with companies to transform and manage their business by unlocking the value of technology in Indonesia.',
            'about_desc' => 'Founded in 2008, PT. Neuronworks Indonesia stands at the forefront of technological innovation. As a leading IT Consultant firm in Indonesia, we specialize in providing tailored IT solutions that empower businesses to thrive in the digital age.',
            'vision_title' => "Enhancing customer performance by making improvements, refinements, and advancements in every aspect of the customer's business process through superior and best IT solutions",
            'mission_title' => 'Mission',
            'vision_desc' => 'Improving customer performance by making improvements. Improvements and progress in all corners of the customers business processes through superior and best IT solutions.',
            'vision_image' => 'img/about/vision_img.jpg',
            'value_title' => 'Our Values',
            'value_subtitle' => 'Our company values are at the core of who we are.',
            'partnership_title' => 'PARTNERSHIPS & CERTIFICATIONS',
            'part_cert_title' => "Over the years, we've fostered partnerships with global tech giants and earned a slew of certifications, underscoring our industry competence and dedication.",
            'part_cert_desc' => 'PARTNERSHIPS',
            'certification_title' => 'CERTIFICATIONS',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
