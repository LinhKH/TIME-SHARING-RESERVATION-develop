<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransportationRouteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transportation_route', function (Blueprint $table) {
            $table->bigInteger('id')->index()->unique()->unsigned();
            $table->char('string_id', 20)->default(null)->index()->nullable()->unique();
            $table->integer('type')->default(null)->nullable()->unsigned();
            $table->double('latitude', 10, 7)->default(null)->nullable()->unsigned();
            $table->double('longitude', 10, 7)->default(null)->nullable()->unsigned();
            $table->integer('order_number')->default(null)->nullable()->unsigned();
            $table->string('colour', 50)->default(null)->nullable();
            $table->tinyInteger('roundtrip')->default(null)->nullable();
            $table->tinyInteger('wheelchair')->default(0);
            $table->string('osm_id', 45)->index()->unique();
            $table->string('route', 45)->default(null)->nullable();
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
        Schema::dropIfExists('transportation_route');
    }
}
