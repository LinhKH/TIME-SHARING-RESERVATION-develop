<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalSpaceReviewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_space_review', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('creation_time')->unsigned();
            $table->bigInteger('customer_id')->index()->unsigned()->nullable();
            $table->foreign('customer_id')->references('id')
                ->on('customer')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->smallInteger('depth')->nullable();
            $table->string('lineage',255)->nullable();
            $table->text('memo')->nullable();
            $table->integer('modification_time')->unsigned();
            $table->bigInteger('parent_id')->index()->unsigned()->nullable();
            $table->foreign('parent_id')->references('id')
                ->on('rental_space_review')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->smallInteger('points');
            $table->bigInteger('rental_space_id')->index()->nullable()->unsigned();
            $table->foreign('rental_space_id')->references('id')
                ->on('rental_space')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->text('review');
            $table->enum('status', ['published', 'disabled', 'deleted'])->default('published');
            $table->string('subject', 255);
            $table->bigInteger('user_id')->index()->unsigned()->nullable();
            $table->foreign('user_id')->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('visit_month_ident')->nullable()->unsigned();
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
        Schema::dropIfExists('rental_space_review');
    }
}
