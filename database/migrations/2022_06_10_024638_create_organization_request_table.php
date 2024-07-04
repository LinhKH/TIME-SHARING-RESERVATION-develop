<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_request', function (Blueprint $table) {
            $table->bigIncrements('id')->index()->unique()->unsigned();
            $table->integer('creation_time')->unsigned();
            $table->string('status', 45);
            $table->string('request_confirmation_token', 255)->default(null)->nullable();
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
        Schema::dropIfExists('organization_request');
    }
}
