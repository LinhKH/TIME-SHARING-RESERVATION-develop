<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalSpaceCouponTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_space_coupon', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->text('customer_ids')->nullable();
            $table->text('days_of_the_week')->nullable();
            $table->tinyInteger('discount_percentage')->unsigned();
            $table->tinyInteger('enabled');
            $table->text('mail_text')->nullable();
            $table->tinyInteger('master');
            $table->text('memo')->nullable();
            $table->string('name');
            $table->integer('number_of_people')->nullable()->unsigned();
            $table->text('plan_ids')->nullable();
            $table->text('space_ids')->nullable();
            $table->integer('usable_from')->nullable()->default(null);
            $table->integer('usable_to')->nullable()->default(null);
            $table->integer('usage_count')->nullable()->unsigned()->default(null);
            $table->integer('valid_from')->nullable()->default(null);
            $table->integer('valid_to')->nullable()->default(null);
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
        Schema::dropIfExists('rental_space_coupon');
    }
}
