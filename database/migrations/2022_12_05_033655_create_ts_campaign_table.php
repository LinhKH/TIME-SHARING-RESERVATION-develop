<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTsCampaignTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ts_campaign', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('body')->nullable();
            $table->enum('kinds', ['discount', 'decoration', 'single'])->default('discount');
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->string('list_title')->nullable();
            $table->string('list_content')->nullable();
            $table->string('title_background')->nullable();
            $table->string('title_recommendation')->nullable();
            $table->string('comment_recommendation')->nullable();
            $table->foreignId('space_recommendation')->nullable()->constrained('rental_space')->onUpdate('cascade')->onDelete('cascade');
            $table->string('title_background_recommendation')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ts_campaign');
    }
}

