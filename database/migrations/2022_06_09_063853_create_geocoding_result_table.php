<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeocodingResultTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('geocoding_result', function (Blueprint $table) {
            $table->string('id', 255)->unique();
            $table->string('formatted_address', 255)->default(null)->nullable();
            $table->double('latitude', 10, 7)->default(null)->nullable();
            $table->double('longitude', 10, 7)->default(null)->nullable();
            $table->string('place_idac', 255)->default(null)->nullable();
            $table->integer('creation_time')->unsigned();
            $table->timestamps();
            $table->index(['id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('geocoding_result');
    }
}
