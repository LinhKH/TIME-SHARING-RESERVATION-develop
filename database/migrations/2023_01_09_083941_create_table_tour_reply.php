<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTourReply extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tour_reply', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tour_id')->unsigned()->index();
            $table->bigInteger('customer_id')->unsigned()->default(null)->nullable()->index();
            $table->bigInteger('user_id')->unsigned()->default(null)->nullable()->index();
            $table->text('description');
            $table->integer('creation_time')->unsigned();
            $table->tinyInteger('is_read')->default(0);
//            $table->foreign('tour_id')->references('id')
//                ->on('tour')
//                ->onUpdate('cascade')
//                ->onDelete('cascade');
//            $table->foreign('customer_id')->references('id')
//                ->on('customer')
//                ->onUpdate('cascade')
//                ->onDelete('cascade');
//            $table->foreign('user_id')->references('id')
//                ->on('users')
//                ->onUpdate('cascade')
//                ->onDelete('cascade');
//            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tour_reply');
    }
}
