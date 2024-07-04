<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpaceSearchFormAreaGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('space_search_form_area_group', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('area_group_id')->index()->unsigned();
            $table->foreign('area_group_id')->references('id')
                ->on('area_group')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->bigInteger('space_search_form_id')->unsigned();
            $table->foreign('space_search_form_id')->references('id')
                ->on('space_search_form')
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
        Schema::dropIfExists('space_search_form_area_group');
    }
}
