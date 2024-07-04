<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationBankAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_bank_account', function (Blueprint $table) {
            $table->bigIncrements('id')->index()->unique()->unsigned();
            $table->string('bank_name', 255);
            $table->string('bank_name_katakana', 255)->default(null)->nullable();
            $table->char('bank_code', 4);
            $table->string('branch_name', 255);
            $table->string('branch_name_katakana', 255)->default(null)->nullable();
            $table->string('branch_code', 3);
            $table->string('type', 40);
            $table->char('account_number', 7);
            $table->string('holder_name_katakana', 255)->default(null)->nullable();
            $table->integer('creation_time')->unsigned();
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
        Schema::dropIfExists('organization_bank_account');
    }
}
