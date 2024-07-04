<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalSpaceFloorPlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_space_floor_plan', function (Blueprint $table) {
            $table->string('id')->unique()->index()->primary();
            $table->integer('creation_time')->unsigned();
            $table->string('extension');
            $table->integer('height')->unsigned();
            $table->integer('length')->unsigned();
            $table->integer('order_number')->unsigned();
            $table->integer('parent_id')->index()->unsigned();
            $table->string('s3key');
            $table->integer('width')->unsigned();
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
        Schema::dropIfExists('rental_space_floor_plan');
    }
}
