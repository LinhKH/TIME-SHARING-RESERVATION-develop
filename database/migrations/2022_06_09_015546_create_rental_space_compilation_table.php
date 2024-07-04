<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalSpaceCompilationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_space_compilation', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('access_key')->index()->unique();
            $table->tinyInteger('active');
            $table->integer('creation_time')->unsigned();
            $table->integer('modification_time')->unsigned();
            $table->integer('order_number')->unsigned();
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
        Schema::dropIfExists('rental_space_compilation');
    }
}
