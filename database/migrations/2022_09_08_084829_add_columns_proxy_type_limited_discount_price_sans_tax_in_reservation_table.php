<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsProxyTypeLimitedDiscountPriceSansTaxInReservationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reservation', function (Blueprint $table) {
            if(!Schema::hasColumn('reservation', 'limited_discount_price_sans_tax')) {
                $table->integer('limited_discount_price_sans_tax')->unsigned()->nullable()->default(0);
            }
            if(!Schema::hasColumn('reservation', 'proxy_reservation_type')) {
                $table->enum('proxy_reservation_type', ['web', 'new_apply', 'extending'])->default('web');
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
        Schema::table('reservation', function (Blueprint $table) {
            $table->dropColumn('limited_discount_price_sans_tax');
            $table->dropColumn('proxy_reservation_type');
        });
    }
}
