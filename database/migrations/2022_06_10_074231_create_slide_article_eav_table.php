<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlideArticleEavTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slide_article_eav', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('attribute');
            $table->bigInteger('namespace')->unsigned();
            $table->foreign('namespace')->references('id')
                ->on('slide_article')
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
        Schema::dropIfExists('slide_article_eav');
    }
}
