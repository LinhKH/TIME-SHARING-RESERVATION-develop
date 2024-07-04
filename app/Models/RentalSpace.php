<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class RentalSpace extends Model
{
    use HasFactory;

    public const RENTAL_SPACE_STATUS_PUBLISHED = "published";

    protected $table = 'rental_space';
    protected $fillable = [
        'id',
        'user_id',
        'admin_changed_status',
        'bookingInformation__lastMinuteBookDiscountDaysBeforeCount',
        'bookingInformation__lastMinuteBookDiscountEnabled',
        'bookingInformation__lastMinuteBookDiscountPercentage',
        'bookingInformation__status',
        'calendar_collaboration_toGcalId',
        'calendar_collaboration_token',
        'calendar_collaboration_toScalId',
        'draft_step',
        'external_image_url',
        'external_site_id',
        'external_space_id',
        'google_calendar_notification_channel_expire_time',
        'google_calendar_notification_channel_id',
        'google_calendar_notification_channel_resource_id',
        'is_approved',
        'is_auto_sync',
        'is_uploaded',
        'locationInformation__areaGroupId',
        'locationInformation__areaId',
        'organization_id',
        'area_id',
        'ts_category_spaces_id',
        'ts_tag_id',
        'page_view_count',
        'page_view_total_count',
        'ranking_score',
        'recommendationInformation__advertisingEnabled',
        'recommendationInformation__featured',
        'recommendationInformation__advertisingEndDayIdent',
        'recommendationInformation__advertisingStartDayIdent',
        'recommendationInformation__totalPoints',
        'recommendationInformation__totalPointsCalculationTime',
        'reservation_request_accept_rate',
        'spaceInformation__minimumBudget',
        'spaceInformation__minimumFee',
        'status',
        'tour_flg',
        'view_count',
        'view_total_count',
        'created_at',
        'updated_at'
    ];
    public $timestamps = true;

    protected $casts = [
        'ts_category_spaces_id' => 'json',
        'ts_tag_id' => 'json',
        'created_at'  => 'date:Y-m-d H:i',
        'updated_at' => 'date:Y-m-d H:i',
    ];

    /**
     * Get the rental_space_eav .
     */
    public function rentalSpaceEav(): HasMany
    {
        return $this->hasMany(RentalSpaceEav::class, 'namespace');
    }

    /**
     * Get the organization.
     */
    public function organizations(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    /**
     * Get the rental_slot_unavailable_cache_entry .
     */
    public function rentalSlotUnavailableCacheEntry(): HasMany
    {
        return $this->hasMany(RentalSlotUnavailableCacheEntry::class, 'rental_space_id');
    }

    /**
     * Get the rental_slot_cache_entry .
     */
    public function rentalSlotCacheEntry(): HasMany
    {
        return $this->hasMany(RentalSlotCacheEntry::class, 'rental_space_id');
    }

    /**
     * Get the rentalSpaceAreaGroup .
     */
    public function rentalSpaceAreaGroup(): HasMany
    {
        return $this->hasMany(RentalSpaceAreaGroup::class, 'rental_space_id');
    }

    /**
     * Get the rental_space_email_message .
     */
    public function rentalSpaceEmailMessage(): HasMany
    {
        return $this->hasMany(RentalSpaceEmailMessage::class, 'rental_space_id');
    }

    /**
     * Get the RentalSpaceFavorite .
     */
    public function rentalSpaceFavorite(): HasMany
    {
        return $this->hasMany(RentalSpaceFavorite::class, 'rental_space_id');
    }

    /**
     * Get the rental_space_nearby_stations .
     */
    public function rentalSpaceNearbyStations(): HasMany
    {
        return $this->hasMany(RentalSpaceNearbyStations::class, 'rental_space_id');
    }

    /**
     * Get the RentalSpacePage .
     */
    public function rentalSpacePage(): HasMany
    {
        return $this->hasMany(RentalSpacePage::class, 'rental_space_id');
    }

    /**
     * Get the RentalSpaceImage .
     */
    public function rentalSpaceImage(): HasMany
    {
        return $this->hasMany(RentalSpaceImage::class, 'parent_id');
    }

    /**
     * Get the Tracking Link .
     */
    public function trackingLink(): HasMany
    {
        return $this->hasMany(TrackingLink::class, 'entity_id');
    }
    /**
     * RelationShip Rental Plan
     * @return HasMany
     */
    public function rentalSpaceRentalPlan(): HasMany
    {
        return $this->hasMany(RentalSpaceRentalPlan::class, 'rental_space_id')->with('rentalSpaceRentalInterval');
    }

    /**
     * RelationShip Rental Interval
     * @return HasMany
     */
    public function rentalSpaceRentalInterval(): HasMany
    {
        return $this->hasMany(RentalSpaceRentalInterval::class, 'namespace');
    }

    /**
     * Relation to Reservation Option Type Reservation Option Type
     */
    public function reservationOptionType(): HasMany
    {
        return $this->hasMany(ReservationOptionTypeReservationOptionType::class, 'rental_space_id');
    }

    /**
     * Relation to Reservation
     */
    public function reservation(): HasMany
    {
        return $this->hasMany(Reservation::class, 'rental_space_id');
    }

    /**
     * Relation to areas
     */
    public function areas(): HasOne
    {
        return $this->hasOne(Area::class, 'id', 'area_id');
    }

    /**
     * Relation to user
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * Filter Location
     */
    public function scopeFilterArea($query, $request)
    {
        if (isset($request['area_id'])) {
            $query->where('area_id', $request['area_id']);
        }

        return $query;
    }

    /**
     * Filter Category
     */
    public function scopeFilterCategory($query, $request)
    {
        if (isset($request['ts_category_spaces_id'])) {
            $query->whereJsonContains('ts_category_spaces_id', $request['ts_category_spaces_id']);
        }

        return $query;
    }

    /**
     * Filter People Count
     */
    public function scopeFilterPeopleCount($query, $request)
    {
        if (isset($request['people_count'])) {
            $query->whereHas('rentalSpaceRentalPlan.rentalSpaceRentalInterval', function ($q) use ($request) {
                if (!empty($request['people_count']['case_person'])) {
                    $q->where('maximum_simultaneous_people', '>', $request['people_count']['case_person']);
                } elseif (!empty($request['people_count']['from']) && !empty($request['people_count']['to'])) {
                    $q->whereBetween('maximum_simultaneous_people', [$request['people_count']['from'], $request['people_count']['to']]);
                }
            });
        }

        return $query;
    }

    /**
     * Filter People Title
     */
    public function scopeFilterTitle($query, $request)
    {
        if (isset($request['title'])) {
            $query->whereHas('rentalSpaceEav', function ($q) use ($request) {
                $q->where('attribute', 'generalBasicSpaceNameJa')->where('value', 'like', "%{$request['title']}%");
            });
        }

        return $query;
    }

    /**
     * Filter People Date
     */
    public function scopeFilterDate($query, $request)
    {
        if (isset($request['date'])) {
            $query->where('created_at', 'like', "%{$request['date']}%");
        }

        return $query;
    }

    /**
     * Filter Status
     */
    public function scopeFilterStatus($query, $request)
    {
        if (isset($request['status'])) {
            $query->where('status', $request['status']);
        }

        return $query;
    }

    /**
     * Filter orderBy created_at
     */
    public function scopeFilterOrderByCreatedAt($query, $request)
    {
        if (isset($request['created_at'])) {
            $query->orderby('created_at', $request['created_at']);
        }

        return $query;
    }
}
