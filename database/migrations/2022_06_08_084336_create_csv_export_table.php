<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCsvExportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('csv_export', function (Blueprint $table) {
            $table->bigIncrements('id')->unique()->unsigned();
            $table->string('target', 100)->default(null)->nullable();
            $table->text('field')->nullable();
            $table->integer('item_order')->unsigned();
            $table->enum('permission', ['all', 'owner', 'admin'])->default('all');
            $table->tinyInteger('shown')->default(1);
            $table->timestamps();
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
        Schema::dropIfExists('csv_export');
    }
}
