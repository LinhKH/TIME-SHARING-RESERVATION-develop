<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaqFaqEavTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faq_faq_eav', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned()->unique();
            $table->bigInteger('namespace')->unsigned();
            $table->string('attribute', 255);
            $table->text('value');
            $table->char('type');
            $table->foreign('namespace')->references('id')
                ->on('faq_faq')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
        Schema::dropIfExists('faq_faq_eav');
    }
}
