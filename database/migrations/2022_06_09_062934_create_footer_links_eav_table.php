<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFooterLinksEavTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('footer_links_eav', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned()->unique();
            $table->string('attribute', 255);
            $table->bigInteger('namespace')->unsigned();
            $table->char('type', 1);
            $table->text('value');
            $table->index(['id']);
            $table->timestamps();
            $table->foreign('namespace')->references('id')
                ->on('footer_links')
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
        Schema::dropIfExists('footer_links_eav');
    }
}
