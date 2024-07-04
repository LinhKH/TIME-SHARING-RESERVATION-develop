<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOwnerFaqEavTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('owner_faq_eav', function (Blueprint $table) {
            $table->bigIncrements('id')->index()->unique()->unsigned();
            $table->bigInteger('namespace')->index()->unsigned();
            $table->string('attribute', 255);
            $table->text('value');
            $table->char('type', 1);
            $table->timestamps();
            $table->foreign('namespace')->references('id')
                ->on('owner_faq')
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
        Schema::dropIfExists('owner_faq_eav');
    }
}
