<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationOrderItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation_order_item', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('people_count')->nullable()->unsigned()->default(null);
            $table->integer('per_person_price')->nullable()->unsigned()->default(null);
            $table->bigInteger('per_person_price_with_fraction')->nullable()->unsigned()->default(null);
            $table->bigInteger('rental_interval_id')->index()->unsigned();
            $table->foreign('rental_interval_id')->references('id')
                ->on('rental_space_rental_interval')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('rental_slot_id')->index();
            $table->bigInteger('reservation_id')->index()->unsigned();
            $table->foreign('reservation_id')->references('id')
                ->on('reservation')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('tenancy_price')->unsigned();
            $table->bigInteger('tenancy_price_with_fraction')->unsigned();
            $table->integer('total_price_sans_tax')->unsigned();
            $table->bigInteger('total_price_sans_tax_with_fraction')->unsigned();
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
        Schema::dropIfExists('reservation_order_item');
    }
}
