<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditTbHome extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('home', function (Blueprint $table) {
            $table->dropColumn(
             'hero_title1',
             'hero_title2',
             'hero_title3',
             'hero_desc',
             'about_project',
             'about_experience',
             'about_ilustration',
             'title_project',
             'title_product',
             'title_certificate', );
            $table->string('hero_image');
            $table->text('service_desc');
            $table->text('partner_desc');
            $table->text('article_desc');
            $table->text('about_desc')->change();
            $table->renameColumn('title_service', 'service_title');
            $table->renameColumn('title_partner', 'partner_title');
            $table->renameColumn('title_articles', 'article_title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('home', function(Blueprint $table) {

            $table->string('hero_title1');
            $table->string('hero_title2');
            $table->string('hero_title3');
            $table->string('hero_desc');
            $table->string('about_project');
            $table->string('about_experience');
            $table->string('about_ilustration');
            $table->string('title_project');
            $table->string('title_product');
            $table->string('title_certificate');

            $table->dropColumn(
                'service_desc',
                'partner_desc',
                'article_desc',
                'hero_image'
            );

            $table->renameColumn( 'service_title','title_service');
            $table->renameColumn( 'partner_title', 'title_partner');
            $table->renameColumn('article_title', 'title_articles' );
        });
    }
}
