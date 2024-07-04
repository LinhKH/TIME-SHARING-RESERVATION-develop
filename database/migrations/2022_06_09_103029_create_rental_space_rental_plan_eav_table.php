<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalSpaceRentalPlanEavTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_space_rental_plan_eav', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('attribute',255);
            $table->bigInteger('namespace')->unsigned();
            $table->foreign('namespace')->references('id')
                ->on('rental_space_rental_plan')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('type')->nullable();
            $table->text('value')->nullable();
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
        Schema::dropIfExists('rental_space_rental_plan_eav');
    }
}
