<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAboutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('about', function (Blueprint $table) {
            $table->id();
            $table->string('about_title');
            $table->string('about_desc');
            $table->string('hero_title');
            $table->string('hero_image');
            $table->string('vision_title');
            $table->string('mission_title');
            $table->string('vision_desc');
            $table->string('vision_image');
            $table->string('value_title');
            $table->string('value_subtitle');
            $table->string('part_cert_title');
            $table->string('part_cert_desc');
            $table->string('partnership_title');
            $table->string('certification_title');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('about');
    }
}
