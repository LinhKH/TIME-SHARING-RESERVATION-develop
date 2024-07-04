<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackingLinkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracking_link', function (Blueprint $table) {
            $table->bigIncrements('id')->index()->unique()->unsigned();
            $table->integer('entity_id')->default(null)->nullable()->unsigned();
            $table->string('name', 250);
            $table->string('tracking_code', 45);
            $table->enum('type', ['global', 'rental_space']);
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
        Schema::dropIfExists('tracking_link');
    }
}
