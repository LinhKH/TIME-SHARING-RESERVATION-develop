<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInquiryReplyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inquiry_reply', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned()->unique()->index();
            $table->bigInteger('inquiry_id')->unsigned()->index();
            $table->bigInteger('customer_id')->unsigned()->default(null)->nullable()->index();
            $table->bigInteger('user_id')->unsigned()->default(null)->nullable()->index();
            $table->text('description');
            $table->integer('creation_time')->unsigned();
            $table->tinyInteger('is_read')->default(0);
            $table->timestamps();
            $table->foreign('inquiry_id')->references('id')
                ->on('inquiry')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('customer_id')->references('id')
                ->on('customer')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('user_id')->references('id')
                ->on('users')
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
        Schema::dropIfExists('inquiry_reply');
    }
}
