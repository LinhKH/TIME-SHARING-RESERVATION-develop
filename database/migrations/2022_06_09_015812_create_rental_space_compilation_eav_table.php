<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalSpaceCompilationEavTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_space_compilation_eav', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('attribute');
            $table->bigInteger('namespace')->index()->unsigned();
            $table->foreign('namespace')->references('id')
                ->on('rental_space_compilation')
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
        Schema::dropIfExists('rental_space_compilation_eav');
    }
}
