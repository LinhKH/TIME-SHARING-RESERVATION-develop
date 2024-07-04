<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned()->unique()->index();
            $table->text('note')->nullable();
            $table->string('locale_key', 4)->nullable();
            $table->tinyInteger('active')->default(1);
            $table->string('type', 20)->nullable();
            $table->integer('creation_time')->unsigned()->nullable();
            $table->bigInteger('parent_organization_id')->unsigned()->default(null)->nullable()->index();
            $table->text('company_information')->nullable();
            $table->string('postal_code', 45)->default(null)->nullable();
            $table->string('url', 255)->default(null)->nullable();
            $table->string('address', 255)->default(null)->nullable();
            $table->double('latitude', 10, 7)->default(null)->nullable();
            $table->double('longitude', 7)->default(null)->nullable();
            $table->string('phone_number', 45)->default(null)->nullable();
            $table->string('fax_number', 45)->default(null)->nullable();
            $table->text('access_information')->nullable();
            $table->integer('area_id')->default(null)->unsigned()->nullable();
            $table->bigInteger('payout_bank_account_id')->default(null)->unsigned()->nullable();
            $table->foreign('payout_bank_account_id')->references('id')->on('organization_bank_account')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('login_count_previous_month')->unsigned()->nullable();
            $table->string('prefecture', 255)->default(null)->nullable();
            $table->string('municipality', 255)->default(null)->nullable();
            $table->tinyInteger('completed_registration')->nullable();
            $table->decimal('handling_fee_percentage', 5, 2)->default(null)->nullable()->unsigned();
            $table->tinyInteger('tied_up')->default(null)->nullable();
            $table->text('tie_up_name')->nullable();
            $table->string('tie_up_menu_title', 255)->default(null)->nullable();
            $table->text('tie_up_menu')->nullable();
            $table->integer('tie_up_area_id')->default(null)->nullable()->unsigned();
            $table->string('tie_up_email', 255)->default(null)->nullable();
            $table->tinyInteger('proceeded_space_search_form_mail')->default(0)->nullable();
            //$table->foreign('parent_organization_id')->references('id')->on('organization')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('organization');
    }
}
