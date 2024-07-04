<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTsCategorySpacesIdToTableRentalSpace extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rental_space', function (Blueprint $table) {
            $table->text('ts_category_spaces_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rental_space', function (Blueprint $table) {
            $table->drop('ts_category_spaces_id');
        });
    }
}

