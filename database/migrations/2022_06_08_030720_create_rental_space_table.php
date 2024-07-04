<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalSpaceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_space', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('admin_changed_status')->nullable();
            $table->tinyInteger('bookingInformation__lastMinuteBookDiscountDaysBeforeCount')->nullable()->unsigned();
            $table->tinyInteger('bookingInformation__lastMinuteBookDiscountEnabled')->unsigned()->nullable();
            $table->tinyInteger('bookingInformation__lastMinuteBookDiscountPercentage')->nullable()->unsigned();
            $table->enum('bookingInformation__status', ['enabled-public', 'enabled-private', 'disabled'])->default('disabled');
            $table->string('calendar_collaboration_toGcalId')->nullable()->default(null)->comment('Google calendar collaboration to google calendar id');
            $table->text('calendar_collaboration_token')->nullable()->comment('Google calendar collaboration token');
            $table->string('calendar_collaboration_toScalId')->nullable()->default(null)->comment('Google calendar collaboration to supenavi calendar id');
            $table->integer('draft_step')->default(0)->unsigned();
            $table->text('external_image_url')->nullable();
            $table->integer('external_site_id')->default(0)->unsigned();
            $table->text('external_space_id')->nullable();
            $table->integer('google_calendar_notification_channel_expire_time')->nullable();
            $table->text('google_calendar_notification_channel_id')->nullable();
            $table->text('google_calendar_notification_channel_resource_id')->nullable();
            $table->tinyInteger('is_approved')->nullable();
            $table->tinyInteger('is_auto_sync')->nullable();
            $table->tinyInteger('is_uploaded')->nullable();
            $table->integer('locationInformation__areaGroupId')->nullable()->unsigned();
            $table->bigInteger('locationInformation__areaId')->index()->nullable()->unsigned();
            $table->foreign('locationInformation__areaId')->references('id')
                ->on('area_area')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->bigInteger('organization_id')->index()->unsigned();
            $table->foreign('organization_id')->references('id')
                ->on('organization')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('page_view_count')->default(0)->unsigned();
            $table->integer('page_view_total_count')->default(0)->unsigned();
            $table->integer('ranking_score')->default(0)->unsigned();
            $table->tinyInteger('recommendationInformation__advertisingEnabled')->nullable()->unsigned();
            $table->tinyInteger('recommendationInformation__featured')->nullable();
            $table->integer('recommendationInformation__advertisingEndDayIdent')->default(0)->unsigned();
            $table->integer('recommendationInformation__advertisingStartDayIdent')->default(0)->unsigned();
            $table->integer('recommendationInformation__totalPoints')->default(0)->unsigned();
            $table->integer('recommendationInformation__totalPointsCalculationTime')->default(0)->unsigned();
            $table->integer('reservation_request_accept_rate')->default(0)->unsigned();
            $table->integer('spaceInformation__minimumBudget')->default(0)->unsigned();
            $table->integer('spaceInformation__minimumFee')->default(0)->unsigned();
            $table->enum('status', ['published', 'archived', 'pending', 'pending-approval'])->default('pending');
            $table->string('tour_flg')->nullable();
            $table->integer('view_count')->unsigned()->default(0);
            $table->integer('view_total_count')->unsigned()->default(0);
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
        Schema::dropIfExists('rental_space');
    }
}
