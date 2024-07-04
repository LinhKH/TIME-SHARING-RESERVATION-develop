<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalSpaceSearchGeneralTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_space_search_general', function (Blueprint $table) {
            $table->bigInteger('rental_space_id')->unsigned()->unique()->primary();
            $table->string('locationInformation__prefecture')->nullable()->default(null);
            $table->string('locationInformation__zip')->nullable()->default(null)->index('li_zip_idx');
            $table->tinyInteger('spaceInformation__exclusiveCheapestPrice')->nullable()->unsigned()->default(null)->index('si_ecp_idx');
            $table->integer('spaceInformation__maximumCapacity')->nullable()->unsigned()->default(null)->index('si_movie_idx');
            $table->text('spaceInformation__movie')->nullable();
            $table->string('title__en')->nullable();
            $table->string('title__ja')->nullable();
            $table->string('titleKana')->nullable();
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
        Schema::dropIfExists('rental_space_search_general');
    }
}
