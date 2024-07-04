<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransportationRouteStationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transportation_route_stations', function (Blueprint $table) {
            $table->bigInteger('id')->index()->unique()->unsigned();
            $table->bigInteger('route_id')->index()->unsigned();
            $table->bigInteger('station_id')->index()->unsigned();
            $table->tinyInteger('type')->default(0);
            $table->tinyInteger('optimized')->default(0);
            $table->tinyInteger('deleted')->default(0)->unsigned();
            $table->timestamps();
            $table->foreign('route_id')->references('id')
                ->on('transportation_route')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('station_id')->references('id')
                ->on('transportation_station')
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
        Schema::dropIfExists('transportation_route_stations');
    }
}
