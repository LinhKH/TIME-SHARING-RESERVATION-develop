<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalSpaceRentalPlanGroupEavTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_space_rental_plan_group_eav', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('attribute');
            $table->bigInteger('namespace')->unsigned();
            $table->foreign('namespace')->references('id')
                ->on('rental_space_rental_plan_group')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('type');
            $table->text('value');
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
        Schema::dropIfExists('rental_space_rental_plan_group_eav');
    }
}
