<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('ALTER TABLE partners AUTO_INCREMENT=1');

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('partners')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('partners')->insert([
            [
                'image' => url('/img/partner/bajradaya.png'),
                // 'name' => 'Bajradaya',
                'home_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'image' => url('/img/partner/bimulia.png'),
                // 'name' => 'Bimulia Land',
                'home_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'image' => url('/img/partner/jabarenergi.png'),
                // 'name' => 'Jabar Energi',
                'home_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'image' => url('/img/partner/jabarrekono.png'),
                // 'name' => 'Jabar Rekind Geothermal',
                'home_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'image' => url('/img/partner/jasamarga.png'),
                // 'name' => 'Jasamarga',
                'home_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'image' => url('/img/partner/mandiri.png'),
                // 'name' => 'Mandiri',
                'home_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'image' => url('/img/partner/mitratel.png'),
                // 'name' => 'Mitratel',
                'home_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'image' => url('/img/partner/sigmasolusi.png'),
                // 'name' => 'Sigma Solusi Integrasi',
                'home_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'image' => url('/img/partner/tekomindonesia.png'),
                // 'name' => 'Telkom Indonesia',
                'home_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'image' => url('/img/partner/telin.png'),
                // 'name' => 'Telin',
                'home_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'image' => url('/img/partner/telkomcel.png'),
                // 'name' => 'Telkomcel',
                'home_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'image' => url('/img/partner/telkomsat.png'),
                // 'name' => 'Telkomsat',
                'home_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'image' => url('/img/partner/argojabar.png'),
                // 'name' => 'Agro Jabar',
                'home_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'image' => url('/img/partner/Biro_Klarifikasi_Indonesia.png'),
                // 'name' => 'Biro Klarifikasi Indonesia',
                'home_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'image' => url('/img/partner/Dapen_Telkom.png'),
                // 'name' => 'Dapen Telkom',
                'home_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'image' => url('/img/partner/ichibento.png'),
                // 'name' => 'Ichi Bento',
                'home_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'image' => url('/img/partner/Jabar_Bumi_Konstrukssi.png'),
                // 'name' => 'Jabar Bumi Konstruksi',
                'home_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'image' => url('/img/partner/Jabar_energi.png'),
                // 'name' => 'Jabar Energi',
                'home_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'image' => url('/img/partner/Jabar_Rekind_Geothermal.png'),
                // 'name' => 'Jabar Rekind Geothermal',
                'home_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'image' => url('/img/partner/jabarlajutransindo.png'),
                // 'name' => 'Jabar Laju Transindo',
                'home_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'image' => url('/img/partner/jabartel.png'),
                // 'name' => 'Jabartel',
                'home_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'image' => url('/img/partner/jasa_medivest.png'),
                // 'name' => 'Jasa Medivest',
                'home_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'image' => url('/img/partner/KlinikPratamaSenoMedika.png'),
                // 'name' => 'Klinik Pratama Seno Medika',
                'home_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'image' => url('/img/partner/KPS.png'),
                // 'name' => 'Karya Putra Sangkuriang',
                'home_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'image' => url('/img/partner/Nibras.png'),
                // 'name' => 'Nibras',
                'home_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'image' => url('/img/partner/PT_Jasa_Sarana.png'),
                // 'name' => 'Jasa Sarana',
                'home_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'image' => url('/img/partner/PTMandiriUtamaFinance.png'),
                // 'name' => 'Mandiri Utama Finance',
                'home_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'image' => url('/img/partner/PTMethaporaandalanUtama.png'),
                // 'name' => 'Methapora Andalan Utama',
                'home_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'image' => url('/img/partner/RSIAHumanaPrima.png'),
                // 'name' => 'RSIA Humana Prima',
                'home_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'image' => url('/img/partner/rumah_mulia_Indonesia.png'),
                // 'name' => 'Bimulia Land',
                'home_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
