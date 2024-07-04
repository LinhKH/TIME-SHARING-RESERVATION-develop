<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalSpaceRentalPlanImageEavTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_space_rental_plan_image_eav', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('attribute',255);
            $table->string('namespace',255);
            $table->foreign('namespace')->references('id')
                ->on('rental_space_rental_plan_image')
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
        Schema::dropIfExists('rental_space_rental_plan_image_eav');
    }
}
