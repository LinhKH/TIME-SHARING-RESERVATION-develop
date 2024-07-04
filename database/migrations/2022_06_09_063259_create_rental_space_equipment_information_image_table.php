<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalSpaceEquipmentInformationImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_space_equipment_information_image', function (Blueprint $table) {
            $table->string('id')->index()->unique()->primary();
            $table->integer('creation_time')->unsigned();
            $table->string('extension');
            $table->integer('height')->unsigned();
            $table->integer('length')->unsigned();
            $table->string('name');
            $table->bigInteger('parent_id')->index()->unsigned();
            $table->foreign('parent_id')->references('id')
                ->on('rental_space_equipment_information')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
        Schema::dropIfExists('rental_space_equipment_information_image');
    }
}
