<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTypeStepToRentalSpaceEavTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rental_space_eav', function (Blueprint $table) {
            if(!Schema::hasColumn('rental_space_eav', 'type_step')) {
                $table->string("type_step")->default(null)->nullable()->after('type');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rental_space_eav', function (Blueprint $table) {
            $table->dropColumn('type_step');
        });
    }
}
