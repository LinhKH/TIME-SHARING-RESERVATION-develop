<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrganizationIdToOrganizationBankAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organization_bank_account', function (Blueprint $table) {
            if(!Schema::hasColumn('organization_bank_account', 'organization_id')) {
                $table->bigInteger('organization_id')->index()->unsigned();
                $table->foreign('organization_id', 'organization_bank_account_fk_org')->references('id')->on('organization')->onUpdate('cascade')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('organization_bank_account', function (Blueprint $table) {
            $table->dropColumn('organization_id');
        });
    }
}
