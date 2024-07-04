<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationOptionTypeReservationOptionTypeEavTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation_option_type_reservation_option_type_eav', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('attribute');
            $table->bigInteger('namespace')->unsigned();
            $table->foreign('namespace', 'n_fk')->references('id')
                ->on('reservation_option_type_reservation_option_type')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('type')->nullable();
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
        Schema::dropIfExists('reservation_option_type_reservation_option_type_eav');
    }
}
