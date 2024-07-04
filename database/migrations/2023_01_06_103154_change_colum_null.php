<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumNull extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('area_area', function (Blueprint $table) {
            $table->string('title__en',225)->nullable()->change();
            $table->string('title__ja',225)->nullable()->change();
            $table->string('title__ja_kana',225)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('area_area', function (Blueprint $table) {
            //
        });
    }
}
