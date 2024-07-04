<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalSpaceEquipmentInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_space_equipment_information', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('active');
            $table->string('category_id')->index();
            $table->string('checkbox_label_type')->default('available');
            $table->string('default_value')->nullable()->default(null);
            $table->tinyInteger('frequently_used');
            $table->integer('legacy_id')->nullable()->default(null);
            $table->integer('order_number')->unsigned();
            $table->integer('parent_id')->nullable()->default(null);
            $table->tinyInteger('required');
            $table->string('string_id');
            $table->string('type');
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
        Schema::dropIfExists('rental_space_equipment_information');
    }
}
