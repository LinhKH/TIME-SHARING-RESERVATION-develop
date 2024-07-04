<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransportationStationEavTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transportation_station_eav', function (Blueprint $table) {
            $table->bigIncrements('id')->index()->unique()->unsigned();
            $table->string('attribute', 255);
            $table->bigInteger('namespace')->index()->unsigned();
            $table->char('type', 1);
            $table->text('value');
            $table->timestamps();
            $table->foreign('namespace')->references('id')
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
        Schema::dropIfExists('transportation_station_eav');
    }
}
