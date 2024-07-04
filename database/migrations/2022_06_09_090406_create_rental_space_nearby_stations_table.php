<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalSpaceNearbyStationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_space_nearby_stations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('joined_stations');
            $table->string('ref', 255)->nullable();
            $table->bigInteger('rental_space_id')->index()->unsigned();
            $table->foreign('rental_space_id')->references('id')
                ->on('rental_space')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->bigInteger('transportation_station_id')->index()->unsigned();
            $table->foreign('transportation_station_id')->references('id')
                ->on('transportation_station')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->smallInteger('walking_duration')->unsigned();
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
        Schema::dropIfExists('rental_space_nearby_stations');
    }
}
