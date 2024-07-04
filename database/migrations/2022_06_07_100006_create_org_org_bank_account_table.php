<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrgOrgBankAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('org_org_bank_account', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('payout_bank_account_id')->default(null)->index()->nullable()->unsigned();
            $table->foreign('payout_bank_account_id', 'payout_bank_account_fk1')->references('id')->on('organization_bank_account')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('organization_id')->index()->unsigned();
            $table->foreign('organization_id', 'organization_fk2')->references('id')->on('organization')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('organization_organization_bank_account');
    }
}
