<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCateringInquiryFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catering_inquiry_form', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned()->unique();
            $table->integer('creation_time')->unsigned();
            $table->string('type', 255);
            $table->string('name', 255);
            $table->string('kana', 255);
            $table->string('email', 255);
            $table->string('phonenumber', 255);
            $table->string('organization_name', 255)->default(null)->nullable();
            $table->text('venue_address')->nullable();
            $table->integer('planning_date')->unsigned()->default(null)->nullable();
            $table->tinyInteger('planning_date_include_time')->unsigned()->default(0);
            $table->integer('number_of_people')->unsigned()->default(null)->nullable();
            $table->integer('badget_per_person')->unsigned()->default(null)->nullable();
            $table->string('usage_type', 255)->default(null)->nullable();
            $table->text('menu')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->index(['id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('catering_inquiry_form');
    }
}
