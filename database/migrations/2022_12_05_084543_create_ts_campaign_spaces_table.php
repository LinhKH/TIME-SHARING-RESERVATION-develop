<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTsCampaignSpacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ts_campaign_spaces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ts_campaign_id')->constrained('ts_campaign')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('rental_space_id')->constrained('rental_space')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->text('comment')->nullable();
            $table->string('image')->nullable();
            $table->json('schedule')->nullable();
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
        Schema::dropIfExists('ts_campaign_spaces');
    }
}
