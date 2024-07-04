<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reservation extends Model
{
    use HasFactory;

    protected $table = 'reservation';
    protected $fillable = [
        'id',
        'admin_internal_notes',
        'bank_transfer',
        'bills_download_count',
        'business_structure',
        'cancelation_penalty_fee_charged',
        'cancelation_penalty_fee_percentage_desired',
        'cancelation_reason',
        'cancelation_responsible',
        'cancelation_time',
        'cancelation_time_temporary_reservation',
        'canceler',
        'cancellation_coupon_applicable',
        'cancellation_fee',
        'cancellation_fee_tax',
        'cancellation_message',
        'cancellation_percentage',
        'cancellation_reason_type',
        'catering_support',
        'cc_charging_fee_percentage',
        'cc_charging_fee_sans_tax',
        'cc_charging_fee_sans_tax_with_fraction',
        'consult_delivery',
        'contiguous_use_discount_amount',
        'contiguous_use_discount_amount_with_fraction',
        'contiguous_use_discount_minutes',
        'coupon_discount_percentage',
        'coupon_discount_sans_tax',
        'coupon_discount_sans_tax_with_fraction',
        'coupon_id',
        'coupon_name',
        'creation_time',
        'customer_id',
        'customer_usage_reminder_processing_start_time',
        'customer_usage_reminder_status',
        'day_ident',
        'deny_message',
        'deny_reason_type',
        'deny_reservation_request_reason',
        'duplicity_check_ident',
        'first_confirmation_reminder_processing_start_time',
        'first_confirmation_reminder_status',
        'first_contractor_id',
        'first_contractor_supplement',
        'from_ads_section',
        'frontend_reservation_type',
        'gmo_tran_detail',
        'google_event_id',
        'handling_fee_sans_tax',
        'handling_fee_sans_tax_with_fraction',
        'hour_to_approval',
        'is_uploaded',
        'last_minute_book_deal_days_count',
        'last_minute_book_total_price_discount_percentage',
        'last_slot_end_time',
        'memo_customer',
        'memo_owner',
        'note',
        'notification_time_temporary_reservation',
        'options_price_sans_tax',
        'options_price_sans_tax_with_fraction',
        'organization_profit_sans_tax',
        'organization_profit_sans_tax_with_fraction',
        'owner_internal_notes',
        'owner_usage_reminder_processing_start_time',
        'owner_usage_reminder_status',
        'payment_bank_account_id',
        'payment_last_failure_message',
        'payment_method',
        'payment_process_ident',
        'payment_process_start_time',
        'payment_refunded_time',
        'payment_scheduled_time',
        'payment_success_time',
        'payment_transaction_reference',
        'people_count',
        'planless',
        'planless_end_time',
        'planless_start_time',
        'post_to_space_search_form',
        'previous_status',
        'queue_temporary_reservation',
        'receipt_download_count',
        'regular_handling_fee_percentage',
        'reminder_processing_start_time',
        'reminder_status',
        'rental_space_id',
        'reserved_by_econtext_member',
        'reserved_by_google_event',
        'second_confirmation_reminder_processing_start_time',
        'second_confirmation_reminder_status',
        'space_questions_answer',
        'status',
        'status_at_cancellation_request',
        'subject_to_handling_fee',
        'suggested_rental_space_id_1',
        'suggested_rental_space_id_2',
        'suggested_rental_space_id_3',
        'tax_percentage',
        'total_price_before_coupon_sans_tax',
        'total_price_before_coupon_sans_tax_with_fraction',
        'total_price_override_sans_tax',
        'total_price_override_sans_tax_with_fraction',
        'total_price_sans_tax',
        'total_price_sans_tax_with_fraction',
        'tracking_reference_id',
        'use_purpose_category',
        'use_purpose_for_other',
        'user_id',
        'users_receiving_reservation_emails',
        'withdraw_reservation_request_reason',
        'user_booking_data',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;

    protected $casts = [
        'user_booking_data' => 'json',
        'created_at' => 'date:Y-m-d H:i',
        'updated_at' => 'date:Y-m-d H:i',
    ];

    /**
     * Relation to Rental Space
     */
    public function rentalSpace(): BelongsTo
    {
        return $this->belongsTo(RentalSpace::class, 'rental_space_id')->with('rentalSpaceEav');
    }

    /**
     * Get the rental_space_eav .
     */
    public function rentalSpaceEav(): HasMany
    {
        return $this->hasMany(RentalSpaceEav::class, 'namespace');
    }

    /**
     * Relation to User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relation to User
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Relation to tracking_link
     */
    public function trackingLinks(): HasMany
    {
        return $this->hasMany(TrackingLink::class, 'id', 'tracking_reference_id');
    }

    /**
     * Filter Reservation Status
     */
    public function scopeFilterStatus($query, $request)
    {
        if (isset($request['status'])) {
            $query->whereIn('status', $request['status']);
        }

        return $query;
    }

    /**
     * Filter Purpose Of Use
     */
    public function scopeFilterUsePurposeCategory($query, $request)
    {
        if (isset($request['use_purpose_category'])) {
            $query->whereIn('use_purpose_category', $request['use_purpose_category']);
        }

        return $query;
    }

    /**
     * Filter Purpose of use details
     */
    public function scopeFilterUsePurposeForOther($query, $request)
    {
        if (isset($request['use_purpose_for_other'])) {
            $query->where('use_purpose_for_other', 'like', "%{$request['use_purpose_for_other']}%");
        }

        return $query;
    }

    /**
     * Filter Prefectures
     */
    public function scopeFilterPrefectures($query, $request)
    {
        if (isset($request['prefectures'])) {
            $query->whereHas('customer', function ($q) use ($request) {
                $q->where('address', 'like', "%{$request['prefectures']}%");
            });
        }

        return $query;
    }

    /**
     * Filter Proxy Reservation
     */
    public function scopeFilterProxyReservationType($query, $request)
    {
        if (isset($request['proxy_reservation_type'])) {
            $query->whereIn('proxy_reservation_type', $request['proxy_reservation_type']);
        }

        return $query;
    }

    // function filter Proxy reservation Reservation type - Pending

    /**
     * Filter Online Reservation
     */
    public function scopeFilterFrontendReservationType($query, $request)
    {
        if (isset($request['frontend_reservation_type'])) {
            $query->whereIn('frontend_reservation_type', $request['frontend_reservation_type']);
        }

        return $query;
    }

    /**
     * Filter Eating and drinking arrangement consultation
     */
    public function scopeFilterEatingAndDrinkingArrangementConsultation($query, $request)
    {
        if (isset($request['consult_delivery'])) {
            $query->where('consult_delivery', $request['consult_delivery']);
        }

        return $query;
    }

    /**
     * Filter Via PR frame
     */
    public function scopeFilterViaPrFrame($query, $request)
    {
        if (isset($request['from_ads_section'])) {
            $query->where('from_ads_section', $request['from_ads_section']);
        }

        return $query;
    }

    /**
     * Filter Tracking link (Supenavi)
     */
    public function scopeFilterTrackingLinkSupenavi($query, $request)
    {
        if (isset($request['tracking_link_supenavi'])) {
            if ($request['tracking_link_supenavi'] == 'none') {
                $query->whereHas('trackingLinks', function ($q) use ($request) {
                    $request['tracking_link_supenavi'] = 'global';
                    $q->where('type', $request['tracking_link_supenavi']);
                });
            } elseif ($request['tracking_link_supenavi'] == 'canbe') {
                $query->whereHas('trackingLinks', function ($q) use ($request) {
                    $request['tracking_link_supenavi'] = 'rental_space';
                    $q->where('type', $request['tracking_link_supenavi']);
                });
            }
        }

        return $query;
    }

    // function filter Tracking link (owner) - Pending // chung  với  Filter Tracking link (Supenavi)

    /**
     * Filter Coupon
     */
    public function scopeFilterCouponId($query, $request)
    {
        if (isset($request['coupon_status'])) {
            if ($request['coupon_status'] === "null") {

                $query->whereNull('coupon_id');
            } elseif ($request['coupon_status'] === "notnull") {

                $query->whereNotNull('coupon_id');
            }
        }

        return $query;
    }

    /**
     * Filter User category
     */
    public function scopeFilterUserCategory($query, $request)
    {
        if (isset($request['business_structure'])) {
            $query->where('business_structure', $request['business_structure']);
        }

        return $query;
    }

    /**
     * Filter Reservation ID
     */
    public function scopeFilterReservationId($query, $request)
    {
        if (isset($request['id'])) {
            $query->where('id', $request['id']);
        }

        return $query;
    }

    /**
     * Filter Reservation Name
     */
    public function scopeFilterCouponName($query, $request)
    {
        if (isset($request['coupon_name'])) {
            $query->where('coupon_name', 'like', "%{$request['coupon_name']}%");
        }

        return $query;
    }

    /**
     * Filter Customer Email
     */
    public function scopeFilterEmail($query, $request)
    {
        if (isset($request['email'])) {
            $query->whereHas('customer', function ($q) use ($request) {
                $q->where('email', $request['email']);
            });
        }

        return $query;
    }

    /**
     * Filter Customer Phone Number
     */
    public function scopeFilterPhoneNumber($query, $request)
    {
        if (isset($request['phone_number'])) {
            $query->whereHas('customer', function ($q) use ($request) {
                $q->where('phone_number', $request['phone_number']);
            });
        }

        return $query;
    }

    /**
     * Filter Space name
     */
    public function scopeFilterSpaceName($query, $request)
    {
        if (isset($request['space_name'])) {
            $query->whereHas('rentalSpace.rentalSpaceEav', function ($q) use ($request) {
                $q->where('value', $request['space_name']);
            });
        }

        return $query;
    }

    /**
     * Filter Rental Space Id
     */
    public function scopeFilterRentalSpaceId($query, $request)
    {
        if (isset($request['rental_space_id'])) {
            $query->whereHas('rentalSpace', function ($q) use ($request) {
                $q->where('id', $request['rental_space_id']);
            });
        }

        return $query;
    }

    /**
     * Filter TrackingLinkText
     */
    public function scopeFilterTrackingLinkText($query, $request)
    {
        if (isset($request['tracking_link_text'])) {
            $query->whereHas('trackingLinks', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request['tracking_link_text']}%");
            });
        }

        return $query;
    }

    public function scopeFilterTrackingReferenceId($query, $request)
    {
        if (isset($request['tracking_reference_id'])) {
            $query->where('tracking_reference_id', $request['tracking_reference_id']);
        }

        return $query;
    }

    /**
     * Filter Number of people
     */
    public function scopeFilterPeopleCount($query, $request)
    {
        if (isset($request['people_count'])) {
            if (!empty($request['people_count']['case_person'])) {
                $query->where('people_count', $request['people_count']['case_person']);
            } elseif (!empty($request['people_count']['from']) && !empty($request['people_count']['to'])) {
                $query->whereBetween('people_count', [$request['people_count']['from'], $request['people_count']['to']]);
            }
        }

        return $query;
    }

    /**
     * Filter Scheduled date of use (period)
     */
    public function scopeFilterScheduledDateOfUsePeriod($query, $request)
    {
        if (isset($request['scheduled_date_of_use_period'])) {
            if (!empty($request['scheduled_date_of_use_period']['from']) && !empty($request['scheduled_date_of_use_period']['to'])) {
                $query->whereBetween('day_ident', [$request['scheduled_date_of_use_period']['from'], $request['scheduled_date_of_use_period']['to']]);
            }
        }

        return $query;
    }

    /**
     * Filter Reservation completion date (period)
     */
    public function scopeFilterReservationCompletionDatePperiod($query, $request)
    {
        if (isset($request['reservation_completion_date_period'])) {
            if (!empty($request['reservation_completion_date_period']['from']) && !empty($request['reservation_completion_date_period']['to'])) {
                $query->whereBetween('creation_time', [$request['reservation_completion_date_period']['from'], $request['reservation_completion_date_period']['to']]);
            }
        }

        return $query;
    }

    public function scopeFilterUserId($query, $request)
    {
        if (isset($request['user_id'])) {
            $query->where('user_id', $request['user_id']);
        }

        return $query;
    }
}
