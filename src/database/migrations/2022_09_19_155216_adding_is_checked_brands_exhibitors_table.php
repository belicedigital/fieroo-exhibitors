<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddingIsCheckedBrandsExhibitorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('brands_exhibitors', function(Blueprint $table) {
            $table->boolean('is_checked')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('brands_exhibitors', function(Blueprint $table) {
            $table->dropColumn('is_checked');
        });
    }
}
