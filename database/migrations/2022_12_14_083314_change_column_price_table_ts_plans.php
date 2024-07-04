<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnPriceTableTsPlans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ts_plans', function (Blueprint $table) {
            $table->dropColumn('price/per_person');
            $table->integer('price')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ts_plans', function (Blueprint $table) {
            $table->integer('price/per_person')->nullable();
            $table->dropColumn('price');
        });
    }
}
