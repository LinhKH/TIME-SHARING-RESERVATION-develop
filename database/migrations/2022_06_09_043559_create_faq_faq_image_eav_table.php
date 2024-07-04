<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaqFaqImageEavTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faq_faq_image_eav', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned()->unique();
            $table->string('namespace', 255);
            $table->string('attribute', 255);
            $table->text('value');
            $table->char('type', 1);
            $table->timestamps();
            $table->index(['id']);
            $table->foreign('namespace')->references('id')->on('faq_faq_image')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faq_faq_image_eav');
    }
}
