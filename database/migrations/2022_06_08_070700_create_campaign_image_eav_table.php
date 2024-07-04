<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignImageEavTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_image_eav', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned()->unique();
            $table->string('namespace', 255);
            $table->string('attribute', 255);
            $table->text('value');
            $table->char('type', 1);
            $table->index(['id', 'namespace']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaign_image_eav');
    }
}
