<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFooterLinksCategoryEavTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('footer_links_category_eav', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned()->unique();
            $table->string('attribute', 255);
            $table->bigInteger('namespace')->unsigned();
            $table->char('type');
            $table->text('value');
            $table->index(['id']);
            $table->timestamps();
            $table->foreign('namespace')->references('id')
                ->on('footer_links_category')
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
        Schema::dropIfExists('footer_links_category_eav');
    }
}
