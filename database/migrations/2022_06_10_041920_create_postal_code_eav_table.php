<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostalCodeEavTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postal_code_eav', function (Blueprint $table) {
            $table->bigIncrements('id')->index()->unique()->unsigned();
            $table->bigInteger('namespace')->index()->unsigned();
            $table->string('attribute', 255);
            $table->text('value');
            $table->char('type', 1);
            $table->foreign('namespace')->references('id')
                ->on('postal_code')
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
        Schema::dropIfExists('postal_code_eav');
    }
}
