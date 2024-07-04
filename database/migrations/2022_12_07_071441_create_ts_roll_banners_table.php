<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTsRollBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ts_roll_banners', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('type', ['pick_up', 'space', 'link', 'blog', 'news'])->default('pick_up');
            $table->integer('post_id')->nullable();
            $table->tinyInteger('submission_method')->comment('0: image selection, 1: change title & select image 2: change image only')->nullable();
            $table->tinyInteger('background_change')->comment('0: it does not change, 1: change')->nullable();
            $table->json('url')->nullable();
            $table->tinyInteger('select_with')->comment('0: can be, 1: none')->nullable();
            $table->tinyInteger('background_type_selection')->comment('0: image, 1: colour')->nullable();
            $table->string('color_selection')->nullable();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('ts_roll_banners');
    }
}
