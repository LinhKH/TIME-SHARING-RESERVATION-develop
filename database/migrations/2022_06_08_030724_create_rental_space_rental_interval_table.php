<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalSpaceRentalIntervalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_space_rental_interval', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('applicability_periods');
            $table->string('end_time_formatted');
            $table->enum('holiday_applicability_type', ['holiday-irrelevant', 'holiday-only', 'non-holiday-only'])
                ->default('holiday-irrelevant');
            $table->integer('maximum_simultaneous_people')->nullable()->unsigned();
            $table->integer('maximum_simultaneous_reservations')->nullable()->unsigned();
            $table->integer('next_cache_build_day_ident')->nullable()->unsigned()
                ->default(null)
                ->comment('The day ident for incremental building; 0 to indicate full-rebuild scheduled; NULL for disabled');
            $table->string('next_cache_build_lock_ident')->index()->nullable()->default(null);
            $table->integer('per_person_price')->unsigned();
            $table->bigInteger('per_person_price_with_fraction')->unsigned();
            $table->bigInteger('rental_plan_id')->index()->unsigned();
            $table->foreign('rental_plan_id')->references('id')
                ->on('rental_space_rental_plan')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('start_time_formatted');
            $table->enum('status', ['active', 'archived'])->default('active');
            $table->integer('tenancy_price')->unsigned();
            $table->bigInteger('tenancy_price_with_fraction')->unsigned();
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
        Schema::dropIfExists('rental_space_rental_interval');
    }
}
