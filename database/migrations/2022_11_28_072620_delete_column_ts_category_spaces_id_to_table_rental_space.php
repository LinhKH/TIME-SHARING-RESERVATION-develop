<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteColumnTsCategorySpacesIdToTableRentalSpace extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rental_space', function (Blueprint $table) {
            $table->dropForeign('rental_space_ts_category_spaces_id_foreign');
            $table->dropColumn('ts_category_spaces_id');
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
            //$table->foreignId('ts_category_spaces_id')->nullable()->constrained('ts_category_spaces')->onUpdate('cascade')->onDelete('cascade');
        });
    }
}
