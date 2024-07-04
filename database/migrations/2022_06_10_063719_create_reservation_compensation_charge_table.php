<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationCompensationChargeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation_compensation_charge', function (Blueprint $table) {
            $table->id();
            $table->integer('amount')->unsigned();
            $table->integer('creation_time')->unsigned();
            $table->text('note');
            $table->string('payment_webpay_charge_id');
            $table->bigInteger('reservation_id')->index()->unsigned();
            $table->foreign('reservation_id')->references('id')
                ->on('reservation')
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
        Schema::dropIfExists('reservation_compensation_charge');
    }
}
