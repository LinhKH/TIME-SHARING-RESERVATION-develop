<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaqCategoryEavTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faq_category_eav', function (Blueprint $table) {
            $table->bigIncrements('id')->unique()->unsigned();
            $table->string('attribute', 255);
            $table->integer('namespace')->unsigned();
            $table->char('type');
            $table->text('value');
            $table->index(['id', 'namespace']);
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
        Schema::dropIfExists('faq_category_eav');
    }
}
