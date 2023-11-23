<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignHomeIdToTableCertificate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('certificate', function (Blueprint $table) {
            $table->unsignedBigInteger('about_id');
            $table->foreign('about_id')->references('id')->on('home');
            $table->string('title');
            $table->string('company');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('certificate', function (Blueprint $table) {
            $table->dropForeign('certificate_home_id_foreign');
            $table->dropColumn(['title', 'company', 'about_id']);
        });
    }
}
