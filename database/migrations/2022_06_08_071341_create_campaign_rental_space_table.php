<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignRentalSpaceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_rental_space', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('campaign_id')->unsigned();
            $table->bigInteger('rental_space_id')->unsigned();
            $table->timestamps();
            $table->index(['rental_space_id']);
            $table->foreign('campaign_id')->references('id')->on('campaign')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('rental_space_id')->references('id')->on('rental_space')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaign_rental_space');
    }
}
