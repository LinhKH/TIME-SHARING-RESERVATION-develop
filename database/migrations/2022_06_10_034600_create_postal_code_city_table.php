<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostalCodeCityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postal_code_city', function (Blueprint $table) {
            $table->bigIncrements('id')->index()->unique()->unsigned();
            $table->bigInteger('postal_code_prefecture_id')->index()->unsigned();
            $table->foreign('postal_code_prefecture_id')->references('id')
                ->on('postal_code_prefecture')
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
        Schema::dropIfExists('postal_code_city');
    }
}
