<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTourTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tour', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('4th_choice_date')->nullable()->default(null);
            $table->string('4th_choice_time')->nullable()->default(null);
            $table->text('checklist')->nullable();
            $table->dateTime('entry_time')->nullable()->default(null);
            $table->date('first_choice_date')->nullable()->default(null);
            $table->string('first_choice_time')->nullable()->default(null);
            $table->string('fix_choice_date_column_name')->nullable()->default(null);
            $table->string('fix_choice_time_column_name')->nullable()->default(null);
            $table->text('no_reason')->nullable();
            $table->integer('organization_id')->unsigned();
            $table->integer('rental_space_id')->unsigned();
            $table->date('second_choice_date')->nullable()->default(null);
            $table->string('second_choice_time')->nullable()->default(null);
            $table->string('status');
            $table->date('substitute_first_choice_date')->nullable()->default(null);
            $table->string('substitute_first_choice_time')->nullable()->default(null);
            $table->date('substitute_second_choice_date')->nullable()->default(null);
            $table->string('substitute_second_choice_time')->nullable()->default(null);
            $table->date('substitute_third_choice_date')->nullable()->default(null);
            $table->string('substitute_third_choice_time')->nullable()->default(null);
            $table->date('third_choice_date')->nullable()->default(null);
            $table->string('third_choice_time')->nullable()->default(null);
            $table->text('use_plans_date')->nullable();
            $table->text('use_plans_people')->nullable();
            $table->text('use_purpose')->nullable();
            $table->text('use_purpose_detail')->nullable();
            $table->integer('user_id')->unsigned();
            $table->string('user_view_flg')->default('1');
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
        Schema::dropIfExists('tour');
    }
}
