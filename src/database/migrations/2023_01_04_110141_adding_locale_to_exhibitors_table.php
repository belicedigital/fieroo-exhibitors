<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddingLocaleToExhibitorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('exhibitors', function (Blueprint $table) {
            $table->string('locale', 8)->index()->after('user_id');
            $table->foreign('locale')->references('code')->on('languages')->onDelete('cascade')->onUpdate('cascade');
            $table->unique(['locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exhibitors', function (Blueprint $table) {
            $table->dropForeign(['locale']);
            $table->dropColumn('locale');
        });
    }
}
