<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnSlugToAreasTableAndTsCategorySpacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('areas', function (Blueprint $table) {
            $table->string('slug')->unique()->after('name');
        });

        Schema::table('ts_category_spaces', function (Blueprint $table) {
            $table->string('slug')->unique()->after('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('areas', function (Blueprint $table) {
            $table->drop('card_date_of_expiry');
        });

        Schema::table('customer', function (Blueprint $table) {
            $table->drop('card_date_of_expiry');
        });
    }
}
