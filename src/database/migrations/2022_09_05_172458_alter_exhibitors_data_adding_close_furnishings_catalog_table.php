<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterExhibitorsDataAddingCloseFurnishingsCatalogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exhibitors_data', function(Blueprint $table) {
            $table->boolean('close_furnishings')->default(false);
            $table->boolean('close_catalog')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exhibitors_data', function(Blueprint $table) {
            $table->dropColumn(['close_furnishings','close_catalog']);
        });
    }
}
