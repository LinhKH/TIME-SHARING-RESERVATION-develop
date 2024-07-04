<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_image', function (Blueprint $table) {
            $table->bigIncrements('id')->unique();
            $table->integer('parent_id')->unsigned();
            $table->integer('order_number')->unsigned();
            $table->integer('width')->unsigned();
            $table->integer('height')->unsigned();
            $table->integer('length')->unsigned();
            $table->string('extension', 5);
            $table->string('s3key', 255);
            $table->integer('creation_time')->unsigned();
            $table->timestamps();
            $table->index(['id', 'parent_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaign_image');
    }
}
