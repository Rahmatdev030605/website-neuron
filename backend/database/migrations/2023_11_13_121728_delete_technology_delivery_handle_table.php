<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteTechnologyDeliveryHandleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('deliverables');
        Schema::dropIfExists('handles');
        Schema::dropIfExists('portofolio_technologies');
        Schema::dropIfExists('technologies');
        Schema::dropIfExists('technology_categories');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('deliverables', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
            $table->unsignedBigInteger('portofolio_id');
            $table->foreign('portofolio_id')->references('id')->on('portofolios');
        });

        Schema::create('handles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
            $table->unsignedBigInteger('portofolio_id');
            $table->foreign('portofolio_id')->references('id')->on('portofolios');
        });

        Schema::create('technology_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('technologies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('icon');
            $table->timestamps();
            $table->unsignedBigInteger('technology_category_id');
            $table->foreign('technology_category_id')->references('id')->on('technology_categories');
        });


        Schema::create('portofolio_technologies', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('portofolio_id');
            $table->unsignedBigInteger('technologies_id');
            $table->foreign('portofolio_id')->references('id')->on('portofolios');
            $table->foreign('technologies_id')->references('id')->on('technologies');
        });
    }
}
