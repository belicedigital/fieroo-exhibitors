<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExhibitorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exhibitors', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::create('exhibitors_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('exhibitor_id');
            $table->foreign('exhibitor_id')->references('id')->on('exhibitors')->onDelete('cascade');
            $table->boolean('already_download')->default(false);
            $table->boolean('already_expo')->default(false);
            $table->unsignedBigInteger('stand_type_id');
            $table->foreign('stand_type_id')->references('id')->on('stands_types')->onDelete('cascade');
            $table->string('company');
            $table->string('address');
            $table->string('city');
            $table->string('cap');
            $table->string('province');
            $table->string('phone');
            $table->string('fax')->nullable();
            $table->string('web')->nullable();
            $table->string('responsible');
            $table->string('phone_responsible');
            $table->string('email_responsible');
            $table->string('fiscal_code')->nullable();
            $table->string('vat_number');
            $table->string('uni_code');
            $table->boolean('diff_billing')->default(false);
            $table->string('receiver')->nullable();
            $table->string('receiver_address')->nullable();
            $table->string('receiver_city')->nullable();
            $table->string('receiver_cap')->nullable();
            $table->string('receiver_province')->nullable();
            $table->string('receiver_fiscal_code')->nullable();
            $table->string('receiver_vat_number')->nullable();
            $table->string('receiver_uni_code')->nullable();
            $table->integer('n_modules');
            $table->boolean('is_admitted')->default(false);
            $table->boolean('deposit_received')->default(false);
            $table->boolean('balance_received')->default(false);
            $table->boolean('invoice_sent')->default(false);
            $table->boolean('accept_stats')->default(false);
            $table->boolean('accept_marketing')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exhibitors_data');
        Schema::dropIfExists('exhibitors');
    }
}
