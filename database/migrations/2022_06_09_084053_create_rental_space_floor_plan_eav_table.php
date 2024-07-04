<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalSpaceFloorPlanEavTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_space_floor_plan_eav', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('attribute', 255);
            $table->string('namespace', 255)->index();
            $table->string('type');
            $table->text('value');
            $table->timestamps();
            $table->foreign('namespace')->references('id')
                ->on('rental_space_floor_plan')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rental_space_floor_plan_eav');
    }
}
