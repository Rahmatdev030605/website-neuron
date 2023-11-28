<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableHomeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('home', function (Blueprint $table) {
            $table->id();
            $table->string('hero_image');
            $table->string('about_title');
            $table->text('about_desc');
            $table->string('service_title');
            $table->text('service_desc');
            $table->string('partner_title');
            $table->text('partner_desc');
            $table->string('article_title');
            $table->text('article_desc');
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
        Schema::dropIfExists('home');
    }
}
