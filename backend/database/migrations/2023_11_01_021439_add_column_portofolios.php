<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnPortofolios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('portofolios', function(Blueprint $table) {
            $table->string('service_id')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('portofolios', function(Blueprint $table) {
            $table->dropColumn('service_id');
            $table->enum('category', ['Web App', 'Mobile App', 'Workflow Management System', 'System Integrator', 'Business Intelligence', 'CRM App']);
        });

    }
}
