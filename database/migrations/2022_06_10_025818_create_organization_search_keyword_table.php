<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationSearchKeywordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_search_keyword', function (Blueprint $table) {
            $table->bigInteger('organization_id')->index()->unique()->unsigned()->primary();
            $table->longText('searchable_text');
            $table->foreign('organization_id')->references('id')
                ->on('organization')
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
        Schema::dropIfExists('organization_search_keyword');
    }
}
