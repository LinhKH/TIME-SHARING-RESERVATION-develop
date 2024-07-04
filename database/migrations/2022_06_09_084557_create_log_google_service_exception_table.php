<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogGoogleServiceExceptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_google_service_exception', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned()->unique()->index();
            $table->integer('rental_space_id')->unsigned();
            $table->text('happened_at');
            $table->text('errors');
            $table->integer('creation_time')->unsigned();
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
        Schema::dropIfExists('log_google_service_exception');
    }
}
