<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhinxlogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phinxlog', function (Blueprint $table) {
            $table->bigInteger('version')->index()->unique();
            $table->string('migration_name', 100)->default(null)->nullable();
            $table->timestamp('start_time')->useCurrentOnUpdate();
            $table->timestamp('end_time')->default(null);
            $table->tinyInteger('breakpoint')->default(0);
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
        Schema::dropIfExists('phinxlog');
    }
}
