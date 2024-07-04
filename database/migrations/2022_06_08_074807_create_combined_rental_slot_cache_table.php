<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCombinedRentalSlotCacheTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('combined_rental_slot_cache', function (Blueprint $table) {
            $table->id();
            $table->string('_id', 40);
            $table->integer('rental_space_id')->unsigned()->index();
            $table->integer('rental_plan_id')->unsigned()->index();
            $table->integer('day_ident')->unsigned()->index();
            $table->char('start_time', 5)->index();
            $table->char('end_time', 5)->index();
            $table->integer('numcontracts')->unsigned();
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
        Schema::dropIfExists('combined_rental_slot_cache');
    }
}
