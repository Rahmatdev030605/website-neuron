<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEditRecord extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edit_records', function (Blueprint $table) {
            $table->id();
            $table->enum('action', ['Add', 'Edit', 'Delete']);
            $table->enum('section',[
                'Carrer Job', 'Article Blog', 'Blog Category',
                'Portofio', 'Product', 'Home Page', 'About Page',
                'Service Page', 'Services', 'Methodology',
                'Technology', 'Technology Category', 'User', 'Role'
            ]);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('role_id');
            $table->foreign('role_id')->references('id')->on('roles');
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
        Schema::dropIfExists('edit_records');
    }
}
