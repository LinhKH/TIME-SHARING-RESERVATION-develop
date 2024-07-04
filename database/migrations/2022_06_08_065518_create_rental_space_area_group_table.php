<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalSpaceAreaGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_space_area_group', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('area_group_id')->unsigned()->index();
            $table->foreign('area_group_id')->references('id')
                ->on('area_group')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->bigInteger('rental_space_id')->unsigned();
            $table->foreign('rental_space_id')->references('id')
                ->on('rental_space')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
        Schema::dropIfExists('rental_space_area_group');
    }
}
