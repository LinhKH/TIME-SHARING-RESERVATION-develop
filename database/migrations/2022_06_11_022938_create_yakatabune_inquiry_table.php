<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYakatabuneInquiryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yakatabune_inquiry', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('address')->nullable();
            $table->integer('budget')->unsigned()->nullable();
            $table->integer('creation_time')->unsigned();
            $table->string('email');
            $table->string('internal_notes')->nullable()->default(null);
            $table->string('name');
            $table->integer('number_people')->nullable()->unsigned()->default(null);
            $table->string('organization')->nullable()->default(null);
            $table->string('person_in_charge')->nullable()->default(null);
            $table->integer('planning_date')->unsigned()->nullable()->default(null);
            $table->string('support_status')->nullable();
            $table->string('telephone');
            $table->string('type')->nullable()->default(null);
            $table->string('zipcode')->nullable()->default(null);
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
        Schema::dropIfExists('yakatabune_inquiry');
    }
}
