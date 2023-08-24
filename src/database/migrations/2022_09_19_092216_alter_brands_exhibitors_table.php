<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterBrandsExhibitorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('brands_exhibitors', function(Blueprint $table) {
            $table->string('logo')->nullable();
            $table->string('photo')->nullable();
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone_2')->nullable();
            $table->string('city')->nullable();
            $table->string('nation')->nullable();
            $table->text('description')->nullable();
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
            $table->dropColumn(['logo', 'photo', 'website', 'email', 'phone', 'phone_2', 'city', 'nation', 'description']);
        });
    }
}
