<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalSpaceRentalPlanRentalPlanGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_space_rental_plan_rental_plan_group', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('rental_plan_group_id')->nullable()->unsigned()->default(null);
            $table->foreign('rental_plan_group_id','rpg_fk1')->references('id')
                ->on('rental_space_rental_plan_group')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->bigInteger('rental_plan_id')->nullable()->unsigned()->default(null);
            $table->foreign('rental_plan_id','rpi_fk1')->references('id')
                ->on('rental_space_rental_plan')
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
        Schema::dropIfExists('rental_space_rental_plan_rental_plan_group');
    }
}
