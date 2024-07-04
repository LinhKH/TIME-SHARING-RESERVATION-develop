<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned()->unique();
            $table->string('nickname', 255)->default(null)->nullable();
            $table->string('facebook_user_id', 55)->default(null)->nullable()->unique();
            $table->string('company_name', 255)->default(null)->nullable();
            $table->string('company_name_kana', 255)->default(null)->nullable();
            $table->string('first_name', 255)->default(null)->nullable();
            $table->string('last_name', 255)->default(null)->nullable();
            $table->string('first_name_kana', 255)->default(null)->nullable();
            $table->string('last_name_kana', 255)->default(null)->nullable();
            $table->string('email', 255)->default(null)->nullable();
            $table->string('password', 255)->default(null)->nullable();
            $table->string('phone_number', 255)->default(null)->nullable();
            $table->text('address')->nullable();
            $table->integer('birthday_day_ident')->unsigned()->nullable();
            $table->string('card_holder_first_name', 255)->default(null)->nullable();
            $table->string('card_holder_last_name', 255)->default(null)->nullable();
            $table->string('card_type', 25)->default(null)->nullable();
            $table->string('card_reference', 255)->default(null)->nullable();
            $table->string('locale_key', 10);
            $table->string('confirmation_token', 255)->default(null)->nullable();
            $table->string('recovery_token', 255)->default(null)->nullable();
            $table->integer('creation_time')->unsigned();
            $table->tinyInteger('active');
            $table->string('login_email', 255)->default(null)->nullable()->unique();
            $table->enum('type', ['permanent', 'transient', 'deleted']);
            $table->text('next_url')->nullable();
            $table->tinyInteger('receiving_reservation_emails')->default(1);
            $table->tinyInteger('newsletter_subscribed')->default(1);
            $table->enum('gender', ['male', 'female', 'other', 'noanswer', 'unspecified']);
            $table->enum('business_structure', ['organization', 'indivisual'])->default(null)->nullable();
            $table->timestamps();
            $table->index(['id', 'facebook_user_id', 'email', 'login_email', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer');
    }
}
