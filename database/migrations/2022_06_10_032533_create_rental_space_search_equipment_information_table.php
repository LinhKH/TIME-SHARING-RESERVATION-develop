<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalSpaceSearchEquipmentInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_space_search_equipment_information', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('rental_space_equipment_information_id')->index('rsei_idx')->unsigned();
            $table->foreign('rental_space_equipment_information_id','rsei_fk')->references('id')
                ->on('rental_space_equipment_information')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->bigInteger('rental_space_id')->unsigned();
            $table->foreign('rental_space_id','rs_fk')->references('id')
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
        Schema::dropIfExists('rental_space_search_equipment_information');
    }
}
