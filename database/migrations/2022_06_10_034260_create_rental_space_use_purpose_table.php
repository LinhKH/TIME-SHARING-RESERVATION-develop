<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalSpaceUsePurposeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_space_use_purpose', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('active');
            $table->string('category_id')->index();
            $table->string('equipment_information_icons_ids')->nullable()->default(null);
            $table->string('equipment_information_ids')->nullable()->default(null);
            $table->string('equipment_information_ids_mobile')->nullable()->default(null);
            $table->string('legacy_id');
            $table->integer('order_number')->unsigned();
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
        Schema::dropIfExists('rental_space_use_purpose');
    }
}
