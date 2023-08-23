<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddingBillingTotalColumnToExhibitorsDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exhibitors_data', function (Blueprint $table) {
            $table->boolean('invoice_tot_sent')->default(false)->after('invoice_sent');
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
            $table->dropColumn('invoice_tot_sent');
        });
    }
}
