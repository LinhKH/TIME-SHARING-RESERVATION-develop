<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsArticleEavTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_article_eav', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned()->unique()->index();
            $table->string('attribute', 255);
            $table->bigInteger('namespace')->unsigned()->index();
            $table->char('type', 1);
            $table->text('value');
            $table->timestamps();
            $table->foreign('namespace')->references('id')
                ->on('news_article')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news_article_eav');
    }
}
