<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalSlotProhibitionRuleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_slot_prohibition_rule', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('day_ident')->unsigned()->comment('Day Ident (e.g. 20150213)');
            $table->string('type');
            $table->text('google_event_id')->nullable();
            $table->bigInteger('rental_interval_id')->index()->unsigned();
            $table->foreign('rental_interval_id', 'ri_id_fk')->references('id')
                ->on('rental_space_rental_interval')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('rental_slot_id')->index()->default('Denormalized from rental_interval_id and day_ident. The rental slot id (e.g. 3-20160128)');
            $table->bigInteger('reservation_id')->index()->unsigned();
            $table->foreign('reservation_id')->references('id')
                ->on('reservation')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
        Schema::dropIfExists('rental_slot_prohibition_rule');
    }
}
