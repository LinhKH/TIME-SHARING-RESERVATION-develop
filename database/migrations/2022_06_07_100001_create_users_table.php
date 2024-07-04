<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('active');
            $table->integer('creation_time')->unsigned();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('first_name_furigana');
            $table->string('last_name_furigana');
            $table->string('password');
            $table->string('gender');
            $table->integer('last_login_time')->unsigned();
            $table->string('locale_key');
            $table->string('locale_keys_spoken')->nullable();
            $table->integer('login_count_current_month')->unsigned()->nullable();
            $table->tinyInteger('login_trigger');
            $table->tinyInteger('receive_space_search_form_notification');
            $table->tinyInteger('subscribe_mail_magazine');
            $table->bigInteger('organization_id')->index()->unsigned()->nullable();
            $table->foreign('organization_id')->references('id')
                ->on('organization')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('recovery_token')->nullable();
            $table->text('roles')->comment('JSON array of roles');
            $table->text('working_groups')->comment('JSON array of working groups');
            $table->string('type');
            $table->rememberToken()->nullable();
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
        Schema::dropIfExists('users');
    }
}
