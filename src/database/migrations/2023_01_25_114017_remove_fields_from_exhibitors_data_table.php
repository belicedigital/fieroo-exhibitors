<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveFieldsFromExhibitorsDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exhibitors_data', function (Blueprint $table) {
            $table->dropColumn(['already_download', 'already_expo']);
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
            $table->boolean('already_download')->default(0)->after('locale');
            $table->boolean('already_expo')->default(0)->after('locale');
        });
    }
}
