<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalIntervalOverrideConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_interval_override_config', function (Blueprint $table) {
            $table->string('id')->unique()->index()->primary();
            $table->integer('day_ident')->unsigned()->comment('Day Ident (e.g. 20150213)');
            $table->tinyInteger('denied')->unsigned()->nullable();
            $table->integer('maximum_simultaneous_people')->unsigned()->nullable()->default(null);
            $table->integer('maximum_simultaneous_reservations')->unsigned()->nullable()->default(null);
            $table->string('note')->nullable();
            $table->integer('per_person_price')->unsigned();
            $table->bigInteger('per_person_price_with_fraction')->unsigned();
            $table->integer('profit_sans_tax')->unsigned()->nullable()
                ->default(null)
                ->comment('Keeps track if some profit had been made (when denied)');
            $table->bigInteger('rental_interval_id')->index()->unsigned();
            $table->foreign('rental_interval_id')->references('id')
                ->on('rental_space_rental_interval')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('tax_percentage')->unsigned()->nullable()
                ->default(null)
                ->comment('The tax % at the time of profit_sans_tax (for denied)');
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
        Schema::dropIfExists('rental_interval_override_config');
    }
}
