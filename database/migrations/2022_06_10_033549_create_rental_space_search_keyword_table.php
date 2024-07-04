<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalSpaceSearchKeywordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_space_search_keyword', function (Blueprint $table) {
            $table->bigInteger('rental_space_id')->unsigned()->unique()->primary();
            $table->string('rental_space_text')->index();
            $table->foreign('rental_space_id')->references('id')
                ->on('rental_space')
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
        Schema::dropIfExists('rental_space_search_keyword');
    }
}
