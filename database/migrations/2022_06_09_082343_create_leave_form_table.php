<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_form', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned()->unique()->index();
            $table->integer('creation_time')->unsigned();
            $table->bigInteger('customer_id')->default(null)->unsigned()->nullable()->index();
            $table->text('message');
            $table->bigInteger('user_id')->nullable()->default(null)->unsigned()->index();
            $table->timestamps();
            $table->foreign('user_id')->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('customer_id')->references('id')
                ->on('customer')
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
        Schema::dropIfExists('leave_form');
    }
}
