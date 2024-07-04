<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpaceSearchFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('space_search_form', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('area_1_id')->nullable()->default(null);
            $table->integer('area_2_id')->nullable()->default(null);
            $table->integer('area_3_id')->nullable()->default(null);
            $table->integer('badget')->unsigned();
            $table->text('concluded_message')->nullable();
            $table->string('concluded_reason_type')->nullable()->default(null);
            $table->integer('creation_time')->unsigned();
            $table->integer('customer_id')->nullable()->default(null);
            $table->string('email')->nullable()->default(null);
            $table->text('internal_notes')->nullable();
            $table->string('kana')->nullable()->default(null);
            $table->string('name')->nullable()->default(null);
            $table->text('notes')->nullable();
            $table->integer('number_of_people')->unsigned();
            $table->string('person_in_charge')->nullable()->default(null);
            $table->string('phone_number')->nullable()->default(null);
            $table->integer('planning_date')->unsigned();
            $table->integer('planning_end_time')->unsigned();
            $table->integer('planning_start_time')->unsigned();
            $table->tinyInteger('proceeded_to_customer_notification_mail')->default(0);
            $table->text('purpose');
            $table->integer('rental_space_use_purpose_id')->nullable()->default(null);
            $table->string('status');
            $table->text('venue_address')->nullable();
            $table->text('venue_middle_area_1')->nullable();
            $table->text('venue_middle_area_2')->nullable();
            $table->text('venue_middle_area_3')->nullable();
            $table->text('venue_prefecture');
            $table->text('venue_prefecture_2');
            $table->text('venue_prefecture_3');
            $table->text('venue_small_area_1')->nullable();
            $table->text('venue_small_area_2')->nullable();
            $table->text('venue_small_area_3')->nullable();
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
        Schema::dropIfExists('space_search_form');
    }
}
