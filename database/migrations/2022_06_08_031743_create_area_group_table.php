<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreaGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('area_group', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title__en', 255);
            $table->string('title__ja', 255);
            $table->string('title__ja_kana', 255);
            $table->string('identifier', 255)->default(null)->nullable();
            $table->bigInteger('parent_id')->index()->default(null)->nullable()->unsigned();
            $table->integer('order_number')->unsigned();
            $table->tinyInteger('active');
            $table->tinyInteger('address_specifier')->default(1);
            $table->integer('creationTime')->unsigned();
            $table->timestamps();
            $table->foreign('parent_id')->references('id')->on('area_group')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('area_group');
    }
}
