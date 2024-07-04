<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransportationStationSearchKeywordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transportation_station_search_keyword', function (Blueprint $table) {
            $table->bigInteger('station_id')->index()->unique()->unsigned()->primary();
            $table->string('searchable_text')->index();
            $table->foreign('station_id')->references('id')
                ->on('transportation_station')
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
        Schema::dropIfExists('transportation_station_search_keyword');
    }
}
