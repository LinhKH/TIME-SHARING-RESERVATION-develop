<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFkToRentalSpaceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rental_space', function (Blueprint $table) {
            $table->foreignId('area_id')->nullable()->constrained('areas')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('ts_category_spaces_id')->nullable()->constrained('ts_category_spaces')->onUpdate('cascade')->onDelete('cascade');
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
            $table->drop('area_id');
            $table->drop('ts_category_spaces_id');
        });
    }
}
