<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeConstrainInArticles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropForeign('articles_articles_categories_id_foreign');
            $table->dropColumn('articles_categories_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->unsignedBigInteger('articles_categories_id')->default(1);
            $table->foreign('articles_categories_id')->references('id')->on('articles_categories');
        });
    }
}
