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
            $table->renameColumn('image', 'video');
            $table->string('tagline');
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
            $table->renameColumn('video', 'image');
            $table->dropColumn('tagline');
        });
    }
}
