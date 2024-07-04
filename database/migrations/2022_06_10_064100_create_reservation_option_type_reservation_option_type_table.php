<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationOptionTypeReservationOptionTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation_option_type_reservation_option_type', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('active')->default(1);
            $table->integer('category_id')->index('c_idx')->unsigned()->nullable()->default(null);
            $table->integer('maximum_order_quantity')->unsigned();
            $table->integer('minimum_order_quantity')->unsigned();
            $table->integer('order_number')->unsigned();
            $table->integer('rental_space_id')->unsigned();
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
        Schema::dropIfExists('reservation_option_type_reservation_option_type');
    }
}
