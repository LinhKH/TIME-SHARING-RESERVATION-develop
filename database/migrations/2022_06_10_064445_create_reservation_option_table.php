<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationOptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation_option', function (Blueprint $table) {
            $table->id();
            $table->integer('maximum_order_quantity')->unsigned();
            $table->integer('quantity')->unsigned();
            $table->bigInteger('reservation_id')->index()->unsigned();
            $table->foreign('reservation_id')->references('id')
                ->on('reservation')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->bigInteger('reservation_option_type_id')->index('rot_id_idx')->unsigned();
            $table->foreign('reservation_option_type_id','rot_id_fk')->references('id')
                ->on('reservation_option_type_reservation_option_type')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('singular_price_of_sale')->unsigned()->comment('The price for a single item of this option, as observed at the time of sale');
            $table->bigInteger('singular_price_of_sale_with_fraction')->unsigned();
            $table->text('title');
            $table->string('unit_type');
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
        Schema::dropIfExists('reservation_option');
    }
}
