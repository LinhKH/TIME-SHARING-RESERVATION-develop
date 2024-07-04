<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalSlotUnavailableCacheEntryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_slot_unavailable_cache_entry', function (Blueprint $table) {
            $table->string('id')->comment('The rental slot id(e.g 3-20160128)');
            $table->integer('available_seats_count')->unsigned()
                ->nullable()
                ->comment('NULL indicates no-limit');
            $table->integer('day_ident')->unsigned()->comment('Day Ident (e.g. 20150213)');
            $table->integer('most_generous_reservation_window_close_time')->unsigned();
            $table->integer('per_person_price')->unsigned();
            $table->bigInteger('rental_interval_id')->index()->unsigned();
            $table->foreign('rental_interval_id', 'ri_id_fk1_1')->references('id')
                ->on('rental_space_rental_interval')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->bigInteger('rental_space_id')->index()->unsigned()->comment('Denormalized value');
            $table->foreign('rental_space_id', 'rs_id_fk2_1')->references('id')
                ->on('rental_space')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->enum('status', ['reserved', 'orphaned', 'expired', 'denied', 'prohibited', 'not-applicable'])->nullable()->default(null);
            $table->integer('tenancy_price')->unsigned();
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
        Schema::dropIfExists('rental_slot_unavailable_cache_entry');
    }
}
