<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemConfigEavTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_config_eav', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('attribute');
            $table->string('namespace');
            $table->foreign('namespace')->references('id')
                ->on('system_config')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('type');
            $table->text('value')->nullable();
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
        Schema::dropIfExists('system_config_eav');
    }
}
