<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_file', function (Blueprint $table) {
            $table->string('id')->index()->unique()->primary();
            $table->bigInteger('organization_id')->index()->unsigned();
            $table->string('type', 60);
            $table->string('name', 255);
            $table->integer('width')->default(null)->unsigned();
            $table->integer('height')->default(null)->unsigned()->nullable();
            $table->string('extension', 10);
            $table->integer('creation_time')->unsigned();
            $table->foreign('organization_id')->references('id')
                ->on('organization')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
        Schema::dropIfExists('organization_file');
    }
}
