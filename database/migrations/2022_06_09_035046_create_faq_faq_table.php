<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaqFaqTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faq_faq', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned()->unique();
            $table->integer('category_id')->unsigned();
            $table->integer('order_number')->unsigned();
            $table->timestamps();
            $table->index(['id', 'category_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faq_faq');
    }
}
