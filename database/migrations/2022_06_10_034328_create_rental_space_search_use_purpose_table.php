<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalSpaceSearchUsePurposeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_space_search_use_purpose', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('rental_space_id')->unsigned()->index();
            $table->foreign('rental_space_id')->references('id')
                ->on('rental_space')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->bigInteger('rental_space_use_purpose_id')->unsigned()->index('rsup_id_idx');
            $table->foreign('rental_space_use_purpose_id', 'rsup_id_fk')->references('id')
                ->on('rental_space_use_purpose')
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
        Schema::dropIfExists('rental_space_search_use_purpose');
    }
}
