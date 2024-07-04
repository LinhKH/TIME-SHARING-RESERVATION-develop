<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlideArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slide_article', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('active');
            $table->integer('creation_time')->unsigned();
            $table->tinyInteger('desktop_compatible');
            $table->integer('order_number')->unsigned();
            $table->tinyInteger('phone_compatible');
            $table->tinyInteger('tablet_compatible');
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
        Schema::dropIfExists('slide_article');
    }
}
