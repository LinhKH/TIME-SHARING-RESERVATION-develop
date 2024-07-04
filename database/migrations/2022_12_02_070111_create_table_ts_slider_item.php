<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTsSliderItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ts_slider_item', function (Blueprint $table) {
            $table->id();
            $table->string('img', 255)->nullable()->comment("img of item");
            $table->string('comment', 255)->nullable()->comment("comment");
            $table->integer('space_id')->nullable()->comment("space id");
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
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
        Schema::dropIfExists('ts_slider_item');
    }
}
