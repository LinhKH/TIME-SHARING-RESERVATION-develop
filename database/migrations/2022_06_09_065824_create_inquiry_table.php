<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInquiryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inquiry', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned()->unique()->index();
            $table->string('customer_access_token', 255)->default(null)->nullable();
            $table->bigInteger('tour_id')->unsigned()->default(null)->nullable()->index();
            $table->bigInteger('user_id')->unsigned()->default(null)->nullable()->index();
            $table->enum('inquiry_typeWF', ['space', 'reservation', 'tour'])->default('space');
            $table->enum('created_by', ['customer', 'user'])->default('customer');
            $table->bigInteger('customer_id')->unsigned();
            $table->bigInteger('organization_id')->default(null)->nullable()->unsigned();
            $table->bigInteger('rental_space_id')->unsigned()->default(null)->nullable()->index();
            $table->bigInteger('reservation_id')->unsigned()->default(null)->unique()->nullable()->index();
            $table->string('title', 255)->default(null)->nullable();
            $table->text('description');
            $table->integer('creation_time')->unsigned()->index();
            $table->string('from_ads_section', 45)->default(null)->nullable();
            $table->tinyInteger('support_done')->unsigned()->default(0);
            $table->string('support_status', 255)->default(null)->nullable();
            $table->string('person_in_charge', 255)->nullable()->default(null);
            $table->text('internal_notes')->nullable();
            $table->integer('reminded_time')->default(null)->nullable()->unsigned();
            $table->tinyInteger('is_read')->default(0);
            $table->integer('space_search_form_id')->default(null)->nullable();
            $table->integer('offer_rental_space_id')->default(null)->nullable();
            $table->timestamps();
            $table->foreign('customer_id')->references('id')
                ->on('customer')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('organization_id')->references('id')
                ->on('organization')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('rental_space_id')->references('id')
                ->on('rental_space')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('reservation_id')->references('id')
                ->on('reservation')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('user_id')->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('tour_id')->references('id')
                ->on('tour')
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
        Schema::dropIfExists('inquiry');
    }
}
