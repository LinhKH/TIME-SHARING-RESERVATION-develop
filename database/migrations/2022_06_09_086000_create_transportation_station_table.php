<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransportationStationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transportation_station', function (Blueprint $table) {
            $table->bigIncrements('id')->index()->unique()->unsigned();
            $table->tinyInteger('bus');
            $table->char('string_id', 20)->default(null)->index()->nullable()->unique();
            $table->integer('route_id')->default(null)->nullable()->unsigned();
            $table->double('latitude', 10, 7)->default(null)->nullable()->unsigned();
            $table->double('longitude', 10, 7)->default(null)->nullable()->unsigned();
            $table->integer('order_number')->default(null)->nullable()->unsigned();
            $table->tinyInteger('monorail');
            $table->tinyInteger('subway');
            $table->tinyInteger('train');
            $table->tinyInteger('tram');
            $table->tinyInteger('trolleybus');
            $table->tinyInteger('wheelchair');
            $table->string('ref', 255)->default(null)->nullable();
            $table->bigInteger('osm_id')->index()->unique()->unsigned();
            $table->tinyInteger('station')->default(null)->nullable();
            $table->tinyInteger('platform')->default(null)->nullable();
            $table->tinyInteger('platforms')->default(null)->nullable()->unsigned();
            $table->tinyInteger('deleted')->default(0)->unsigned();
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
        Schema::dropIfExists('transportation_station');
    }
}
