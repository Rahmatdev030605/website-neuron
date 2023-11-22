<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNeuronProgramsIdToNeuronProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('neuron_programs', function (Blueprint $table) {
            $table->unsignedBigInteger('neuronPrograms_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('neuron_programs', function (Blueprint $table) {
            $table->dropColumn('neuronPrograms_id');
        });
    }
}
