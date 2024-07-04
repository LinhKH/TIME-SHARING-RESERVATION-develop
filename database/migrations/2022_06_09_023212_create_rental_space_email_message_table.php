<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalSpaceEmailMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_space_email_message', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('creation_time')->unsigned();
            $table->bigInteger('rental_space_id')->unsigned();
            $table->foreign('rental_space_id')->references('id')
                ->on('rental_space')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('type');
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
        Schema::dropIfExists('rental_space_email_message');
    }
}
