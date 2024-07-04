<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpacemarketRoomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spacemarket_room', function (Blueprint $table) {
            $table->id();
            $table->string('address_locality');
            $table->string('address_region');
            $table->integer('creation_day_ident')->nullable()->unsigned()->default(null);
            $table->integer('creation_time')->nullable()->unsigned()->default(null);
            $table->string('owner_name');
            $table->string('room_id');
            $table->text('room_name');
            $table->text('space_name');
            $table->string('street_address')->nullable()->default(null);
            $table->text('url')->nullable();
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
        Schema::dropIfExists('spacemarket_room');
    }
}
