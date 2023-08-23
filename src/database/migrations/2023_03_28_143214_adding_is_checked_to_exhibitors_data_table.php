<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddingIsCheckedToExhibitorsDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exhibitors_data', function (Blueprint $table) {
            $table->boolean('is_admitted')->default(false)->after('accept_marketing');
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
            $table->dropColumn('is_admitted');
        });
    }
}
