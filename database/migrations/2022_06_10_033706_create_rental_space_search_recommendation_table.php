<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalSpaceSearchRecommendationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_space_search_recommendation', function (Blueprint $table) {
            $table->bigInteger('rental_space_id')->unsigned()->unique()->primary();
            $table->tinyInteger('recommendationInformation__hasHpEmbedded')->index('ri_hasHpEmbedded')->nullable()->unsigned()->default(null);
            $table->tinyInteger('recommendationInformation__hasCoverage')->index('ri_hasCoverage')->nullable()->unsigned()->default(null);
            $table->tinyInteger('recommendationInformation__featured2')->index('ri_f2')->nullable()->unsigned()->default(null);
            $table->tinyInteger('recommendationInformation__featured3')->index('ri_f3')->nullable()->unsigned()->default(null);
            $table->tinyInteger('recommendationInformation__featured4')->index('ri_f4')->nullable()->unsigned()->default(null);
            $table->tinyInteger('recommendationInformation__featured5')->index('ri_f5')->nullable()->unsigned()->default(null);
            $table->tinyInteger('recommendationInformation__featured6')->index('ri_f6')->nullable()->unsigned()->default(null);
            $table->tinyInteger('recommendationInformation__featured7')->index('ri_f7')->nullable()->unsigned()->default(null);
            $table->tinyInteger('recommendationInformation__featured8')->index('ri_f8')->nullable()->unsigned()->default(null);
            $table->tinyInteger('recommendationInformation__featured9')->index('ri_f9')->nullable()->unsigned()->default(null);
            $table->tinyInteger('recommendationInformation__featured10')->index('ri_f10')->nullable()->unsigned()->default(null);
            $table->tinyInteger('recommendationInformation__featured11')->index('ri_f11')->nullable()->unsigned()->default(null);
            $table->foreign('rental_space_id')->references('id')
                ->on('rental_space')
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
        Schema::dropIfExists('rental_space_search_recommendation');
    }
}
