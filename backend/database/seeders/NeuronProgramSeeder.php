<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NeuronProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('ALTER TABLE neuron_programs AUTO_INCREMENT=1');

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('neuron_programs')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('neuron_programs')->insert([
            'title' => 'Neuron 3.0 Program',
            'desc' => 'Launch at 2022, Neuron 3.0 Start to Lead program aimed the Neuronworks team to reach out the corporate vision and mission. This program is dedicated to bolstering the passions and performance of all member within the Neuronworks family, thereby driving swift and substantial positive change for our organization. This Neuron 3.0 Start to Lead program has been designed to accelerate the realization of Leading self, Leading team & Leading business.',
            'video' => 'https://www.youtube.com/embed/Zvc3DgDhzhw',
            'tagline'=> 'Leading Self - Leading Team - Leading Business',
            'neuronPrograms_id'=> '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
