<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailTemplateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_template', function (Blueprint $table) {
            $table->id();
            $table->string('email_type')->nullable();
            $table->string('email_subject_en')->nullable();
            $table->string('email_subject_jp')->nullable();
            $table->longText('content_en')->nullable();
            $table->longText('content_jp')->nullable();
            $table->string('memo_en')->nullable();
            $table->string('memo_jp')->nullable();
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
        Schema::dropIfExists('email_template');
    }
}
