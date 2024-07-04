<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_form', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned()->unique();
            $table->timestamps();
            $table->integer('creation_time')->unsigned();
            $table->string('name', 255);
            $table->string('email', 255);
            $table->text('message');
            $table->string('type', 255);
            $table->string('name_furigana', 255);
            $table->string('company_name', 255)->default(null)->nullable();
            $table->string('department', 255)->default(null)->nullable();
            $table->string('phone_number', 255);
            $table->string('support_status', 255)->nullable()->default(null);
            $table->string('person_in_charge', 255)->default(null)->nullable();
            $table->text('internal_notes')->nullable();
            $table->string('enquirer', 255)->default(null)->nullable();
            $table->index(['id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contact_form');
    }
}
