<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreaAreaImageEavTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('area_area_image_eav', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned()->unique();
            $table->string('namespace', 255);
            $table->string('attribute', 255);
            $table->text('value');
            $table->char('type', 1);
            $table->timestamps();
            $table->index(['id']);
//            $table->foreign('namespace')->references('id')->on('area_area_image')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('area_area_image_eav');
    }
}
