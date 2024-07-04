<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned()->unsigned();
            $table->string('alias', 50)->unique();
            $table->string('title', 255);
            $table->text('pr_description')->nullable();
            $table->integer('valid_from')->unsigned()->default(null)->nullable();
            $table->integer('valid_to')->unsigned()->default(null)->nullable();
            $table->tinyInteger('published')->default(0);
            $table->integer('coupon_id')->unsigned()->default(null)->nullable();
            $table->integer('confirm_day_ident')->unsigned()->nullable()->default(null);
            $table->tinyInteger('show_at_index')->default(1);
            $table->text('space_index_url')->nullable();
            $table->tinyInteger('show_alt')->default(0);
            $table->string('type', 255)->default(null)->nullable();
            $table->text('keywords')->nullable();
            $table->text('use_purpose_category_ids')->nullable();
            $table->text('equipment_information')->nullable();
            $table->text('prefectures')->nullable();
            $table->timestamps();
            $table->index(['id', 'alias']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaign');
    }
}
