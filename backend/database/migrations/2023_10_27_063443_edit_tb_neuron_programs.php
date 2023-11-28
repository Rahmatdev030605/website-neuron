<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditTbNeuronPrograms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('neuron_programs', function(Blueprint $table) {
            $table->unsignedBigInteger('home_id')->default(1);
            $table->foreign('home_id')->references('id')->on('neuron_programs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('neuron_programs', function(Blueprint $table) {
            $table->dropForeign('neuron_programs_home_id_foreign');
            $table->dropColumn('home_id');
        });
    }
}
