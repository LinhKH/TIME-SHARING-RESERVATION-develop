<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreaGroupEavTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('area_group_eav', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned()->unique();
            $table->bigInteger('namespace')->unsigned();
            $table->string('attribute', 255);
            $table->text('value');
            $table->char('type');
            $table->index(['id', 'namespace']);
            $table->timestamps();
            $table->foreign('namespace')->references('id')->on('area_group')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('area_group_eav');
    }
}
