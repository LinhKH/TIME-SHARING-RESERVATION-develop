<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalSpaceRentalPlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_space_rental_plan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('allowing_multi_booking');
            $table->bigInteger('bank_account_id')->index()->nullable()->unsigned()->default(null);
            $table->foreign('bank_account_id', 'ba_fk1')->references('id')
                ->on('organization_bank_account')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('handling_fee_percentage')->nullable()->unsigned()->default(null);
            $table->integer('min_contiguous_duration_minutes')->nullable()->unsigned()->default(null);
            $table->bigInteger('rental_plan_group_id')->index()->nullable()->unsigned()->default(null);
            $table->foreign('rental_plan_group_id', 'rpg_fk2')->references('id')
                ->on('rental_space_rental_plan_group')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->bigInteger('rental_space_id')->index()->unsigned();
            $table->foreign('rental_space_id', 'rs_fk3')->references('id')
                ->on('rental_space')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->tinyInteger('requiring_contiguous');
            $table->enum('status', ['active', 'archived'])->default('active');
            $table->enum('type', ['reservation-request', 'instant-reservation'])->default('instant-reservation');
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
        Schema::dropIfExists('rental_space_rental_plan');
    }
}
