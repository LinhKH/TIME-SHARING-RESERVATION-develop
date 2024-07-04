<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationOptionTypeReservationOptionTypeImageEavTable extends Migration
{
    /**
     * Run the migrations.
     * table name: reservation_option_type_reservation_option_type_image_eav
     *
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rot_reservation_option_type_image_eav', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('attribute');
            $table->string('namespace');
            $table->foreign('namespace')->references('id')
                ->on('reservation_option_type_reservation_option_type_image')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('type');
            $table->text('value');
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
        Schema::dropIfExists('reservation_option_type_reservation_option_type_image_eav');
    }
}
