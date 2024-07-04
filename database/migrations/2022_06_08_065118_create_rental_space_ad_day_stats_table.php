<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalSpaceAdDayStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_space_ad_day_stats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ads_section');
            $table->integer('clicks_count')->unsigned();
            $table->integer('day_ident')->unsigned();
            $table->integer('inquiries_count')->unsigned();
            $table->integer('reservations_count')->unsigned();
            $table->integer('views_count')->unsigned();
            $table->integer('rental_space_id')->nullable()->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rental_space_ad_day_stats');
    }
}
