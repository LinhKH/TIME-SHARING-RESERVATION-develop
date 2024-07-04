<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_file', function (Blueprint $table) {
            $table->string('id')->unique()->index()->primary();
            $table->integer('creation_time')->unsigned();
            $table->string('extension');
            $table->integer('height')->unsigned()->nullable();
            $table->integer('width')->unsigned()->nullable();
            $table->string('name');
            $table->string('type');
            $table->bigInteger('user_id')->index()->unsigned()->nullable();
            $table->foreign('user_id')->references('id')
                ->on('users')
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
        Schema::dropIfExists('user_file');
    }
}
