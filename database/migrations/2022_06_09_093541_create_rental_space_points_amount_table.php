<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalSpacePointsAmountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_space_points_amount', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('data_high_limit');
            $table->integer('data_low_limit');
            $table->tinyInteger('item')->unsigned();
            $table->smallInteger('points');
            $table->string('sub_type', 255);
            $table->string('type',255);
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
        Schema::dropIfExists('rental_space_points_amount');
    }
}
