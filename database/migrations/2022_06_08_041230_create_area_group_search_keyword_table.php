<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreaGroupSearchKeywordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('area_group_search_keyword', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('area_group_id')->unsigned()->unique()->index();
            $table->text('area_group_text');
            $table->enum('type', ['prefecture', 'middle-level', 'low-level']);
            $table->timestamps();
            $table->foreign('area_group_id')->references('id')->on('area_group')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('area_group_search_keyword');
    }
}
