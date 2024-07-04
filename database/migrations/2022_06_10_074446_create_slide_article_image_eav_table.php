<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlideArticleImageEavTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slide_article_image_eav', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('attribute');
            $table->string('namespace');
            $table->foreign('namespace')->references('id')
                ->on('slide_article_image')
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
        Schema::dropIfExists('slide_article_image_eav');
    }
}
