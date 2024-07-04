<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation', function (Blueprint $table) {
            $table->id();
            $table->text('admin_internal_notes')->nullable()->comment('Administrator internal notes');
            $table->binary('bank_transfer')->nullable(); //type Blob
            $table->integer('bills_download_count')->nullable()->unsigned()->default(null);
            $table->enum('business_structure', ['organization', 'indivisual'])->nullable()->default(null);
            $table->integer('cancelation_penalty_fee_charged')->nullable()->unsigned()->comment('Actual money that we managed to charge (credit-card only)');
            $table->integer('cancelation_penalty_fee_percentage_desired')->nullable()->unsigned()->default(null)->comment('% of the total that we wanted to charge (credit-card only)');
            $table->text('cancelation_reason')->nullable();
            $table->text('cancelation_responsible')->nullable();
            $table->integer('cancelation_time')->nullable()->unsigned()->comment('The time the status got changed to canceled');
            $table->integer('cancelation_time_temporary_reservation')->nullable()->unsigned();
            $table->string('canceler')->nullable()->comment('Cancelation side (customer or administrator)');
            $table->tinyInteger('cancellation_coupon_applicable')->nullable()->default(null);
            $table->integer('cancellation_fee')->nullable()->unsigned()->default(null);
            $table->integer('cancellation_fee_tax')->nullable()->unsigned()->default(null);
            $table->text('cancellation_message')->nullable();
            $table->integer('cancellation_percentage')->nullable()->unsigned()->default(null);
            $table->string('cancellation_reason_type')->nullable()->default(null);
            $table->string('catering_support')->nullable()->default(null);
            $table->decimal('cc_charging_fee_percentage')->nullable()->unsigned()->default(null)->comment('Credit-card charging fee %. May be specified, even if it does not apply.');
            $table->decimal('cc_charging_fee_sans_tax')->unsigned()->default(0.00)->comment('The credit-card charging fee that we charge, if any. Could become 0 on failure/cancellation.');
            $table->bigInteger('cc_charging_fee_sans_tax_with_fraction')->default(0)->unsigned();
            $table->tinyInteger('consult_delivery')->unsigned()->default(0);
            $table->integer('contiguous_use_discount_amount')->nullable()->unsigned()->default(null)->comment('The conitguous-use discount amount applied');
            $table->bigInteger('contiguous_use_discount_amount_with_fraction')->unsigned()->nullable()->default(null);
            $table->smallInteger('contiguous_use_discount_minutes')->unsigned()->nullable()->default(null);
            $table->tinyInteger('coupon_discount_percentage')->unsigned()->nullable()->default(null);
            $table->integer('coupon_discount_sans_tax')->default(0)->unsigned();
            $table->bigInteger('coupon_discount_sans_tax_with_fraction')->default(0)->unsigned();
            $table->integer('coupon_id')->nullable()->unsigned();
            $table->string('coupon_name')->nullable();
            $table->integer('creation_time')->unsigned();
            $table->bigInteger('customer_id')->index()->unsigned();
            $table->foreign('customer_id')->references('id')
                ->on('customer')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('customer_usage_reminder_processing_start_time')->nullable()->unsigned();
            $table->enum('customer_usage_reminder_status', ['pending', 'processing', 'sent', 'cancelled'])->default('pending');
            $table->integer('day_ident')->index()->unsigned();
            $table->text('deny_message')->nullable();
            $table->string('deny_reason_type')->nullable();
            $table->text('deny_reservation_request_reason')->nullable();
            $table->string('duplicity_check_ident')->index()->unique()->comment('UUID to ensure the same reservation request is not submitted twice');
            $table->integer('first_confirmation_reminder_processing_start_time')->nullable()->unsigned()->default(null);
            $table->enum('first_confirmation_reminder_status', ['pending', 'processing', 'sent', 'cancelled'])->default('pending');
            $table->integer('first_contractor_id')->nullable()->default(null);
            $table->binary('first_contractor_supplement')->nullable();
            $table->string('from_ads_section')->nullable();
            $table->enum('frontend_reservation_type', ['reservation-request', 'instant-reservation', 'temporary-reservation'])->index()->nullable()->default(null);
            $table->binary('gmo_tran_detail')->nullable();
            $table->text('google_event_id')->nullable();
            $table->integer('handling_fee_sans_tax')->unsigned()->default(0)->comment('The handling fee that we charge, if any. Could become 0 on failure/cancellation.');
            $table->bigInteger('handling_fee_sans_tax_with_fraction')->default(0)->unsigned();
            $table->integer('hour_to_approval')->nullable()->unsigned()->default(null);
            $table->tinyInteger('is_uploaded')->default(0);
            $table->tinyInteger('last_minute_book_deal_days_count')->nullable()->unsigned()->default(null);
            $table->tinyInteger('last_minute_book_total_price_discount_percentage')->nullable()->unsigned()->default(null);
            $table->integer('last_slot_end_time')->nullable()->unsigned()->default(null);
            $table->text('memo_customer')->nullable()->comment('Note to customer');
            $table->text('memo_owner')->nullable()->comment('Note to owner');
            $table->text('note')->nullable()->comment('Customer-provided note');
            $table->integer('notification_time_temporary_reservation')->nullable()->unsigned()->default(null);
            $table->integer('options_price_sans_tax')->nullable()->unsigned()->default(null);
            $table->bigInteger('options_price_sans_tax_with_fraction')->nullable()->unsigned()->default(null);
            $table->integer('organization_profit_sans_tax')->nullable()->unsigned()->default(null)->comment('The profit the rental space makes, if any. Could become 0 on failure/cancellation.');
            $table->bigInteger('organization_profit_sans_tax_with_fraction')->nullable()->unsigned()->default(null);
            $table->text('owner_internal_notes')->nullable()->comment('Owner internal notes');
            $table->integer('owner_usage_reminder_processing_start_time')->nullable()->unsigned();
            $table->enum('owner_usage_reminder_status', ['pending', 'processing', 'sent', 'cancelled'])->default('pending');
            $table->bigInteger('payment_bank_account_id')->index()->nullable()->unsigned()->default(null);
            $table->foreign('payment_bank_account_id', 'pba_fk')->references('id')
                ->on('organization_bank_account')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('payment_last_failure_message')->nullable()->default(null);
            $table->enum('payment_method', ['credit-card', 'bank-transfer','cash-on-site', 'other', 'internal-otherwise-handled', 'choose-later-by-customer']);
            $table->string('payment_process_ident')->nullable()->default(null)->comment("Currently running charge process's ident");
            $table->integer('payment_process_start_time')->index()->nullable()->unsigned()->comment("The time the charging process got started");
            $table->integer('payment_refunded_time')->nullable()->unsigned()->comment("The time the status got changed to refunded");
            $table->integer('payment_scheduled_time')->index()->nullable()->unsigned()->comment("The timestamp after which credit-card charging happens");
            $table->integer('payment_success_time')->nullable()->unsigned();
            $table->string('payment_transaction_reference')->nullable()->comment('Unique ID used for idempotent charging');
            $table->integer('people_count')->unsigned();
            $table->tinyInteger('planless')->unsigned()->default(0);
            $table->string('planless_end_time');
            $table->string('planless_start_time')->default(null);
            $table->tinyInteger('post_to_space_search_form')->default(0);
            $table->string('previous_status')->nullable();
            $table->binary('queue_temporary_reservation')->nullable();
            $table->integer('receipt_download_count')->nullable()->unsigned()->default(null);
            $table->decimal('regular_handling_fee_percentage')->nullable()->unsigned()->default(null);
            $table->integer('reminder_processing_start_time')->nullable()->unsigned()->default(null);
            $table->enum('reminder_status', ['pending', 'processing', 'sent', 'cancelled'])->default('pending');
            $table->bigInteger('rental_space_id')->index()->unsigned();
            $table->foreign('rental_space_id', 'rs_id')->references('id')
                ->on('rental_space')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->tinyInteger('reserved_by_econtext_member')->nullable()->default(null);
            $table->tinyInteger('reserved_by_google_event')->default(0);
            $table->integer('second_confirmation_reminder_processing_start_time')->nullable()->unsigned()->default(null);
            $table->enum('second_confirmation_reminder_status', ['pending', 'processing', 'sent', 'cancelled'])->default('pending');
            $table->text('space_questions_answer')->nullable();
            $table->string('status')->nullable();
            $table->string('status_at_cancellation_request')->nullable()->default(null);
            $table->tinyInteger('subject_to_handling_fee')->unsigned()->default(0)->comment('Tells whether handling fees apply to this reservation');
            $table->integer('suggested_rental_space_id_1')->nullable()->default(null);
            $table->integer('suggested_rental_space_id_2')->nullable()->default(null);
            $table->integer('suggested_rental_space_id_3')->nullable()->default(null);
            $table->integer('tax_percentage')->unsigned()->default(0);
            $table->integer('total_price_before_coupon_sans_tax')->unsigned()->comment('The total price (sum of all slot prices), after applying all discounts, but before applying coupon discount.');
            $table->bigInteger('total_price_before_coupon_sans_tax_with_fraction')->unsigned();
            $table->integer('total_price_override_sans_tax')->unsigned()->nullable()->default(null);
            $table->bigInteger('total_price_override_sans_tax_with_fraction')->unsigned()->nullable()->default(null);
            $table->integer('total_price_sans_tax')->unsigned();
            $table->bigInteger('total_price_sans_tax_with_fraction')->unsigned();
            $table->string('tracking_reference_id')->nullable();
            $table->string('use_purpose_category')->nullable();
            $table->text('use_purpose_for_other')->nullable();
            $table->bigInteger('user_id')->index()->nullable()->unsigned()->default(null);
            $table->foreign('user_id')->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->tinyInteger('users_receiving_reservation_emails')->default(1);
            $table->text('withdraw_reservation_request_reason')->nullable();
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
        Schema::dropIfExists('reservation');
    }
}
