<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditTbHeroTitleList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hero_title_list', function(Blueprint $table) {
            $table->renameColumn('title','hero_title');
            $table->text('hero_desc');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hero_title_list', function(Blueprint $table) {
            $table->renameColumn('hero_title','title');
            $table->dropColumn('hero_desc');
        });
    }
}
