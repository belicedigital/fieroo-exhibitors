<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveLocaleFromExhibitorsDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exhibitors_data', function (Blueprint $table) {
            $table->dropColumn('locale');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exhibitors_data', function (Blueprint $table) {
            $table->string('locale')->default('it')->after('exhibitor_id');
        });
    }
}
