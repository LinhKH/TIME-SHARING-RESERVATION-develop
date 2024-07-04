<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RentalSpaceRentalInterval extends Model
{
    use HasFactory;

    protected $table = 'rental_space_rental_interval';
    protected $fillable = [
        'id',
        'applicability_periods',
        'end_time_formatted',
        'holiday_applicability_type',
        'maximum_simultaneous_people',
        'maximum_simultaneous_reservations',
        'next_cache_build_day_ident',
        'next_cache_build_lock_ident',
        'per_person_price',
        'per_person_price_with_fraction',
        'rental_plan_id',
        'start_time_formatted',
        'status',
        'tenancy_price',
        'tenancy_price_with_fraction',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;

    /**
     * RelationShip Rental Interval Override Config
     * @return HasMany
     */
    public function rentalIntervalOverrideConfig(): HasMany
    {
        return $this->hasMany(RentalIntervalOverrideConfig::class, 'rental_interval_id');

    }

    /**
     * RelationShip RentalSlotUnavailableCacheEntry
     * @return HasMany
     */
    public function rentalSlotUnavailableCacheEntry(): HasMany
    {
        return $this->hasMany(RentalSlotUnavailableCacheEntry::class, 'rental_interval_id');

    }

    /**
     * RelationShip RentalSlotUnavailableCacheEntry
     * @return HasMany
     */
    public function rentalSlotCacheEntry(): HasMany
    {
        return $this->hasMany(RentalSlotCacheEntry::class, 'rental_interval_id');

    }

    /**
     * Relationship RentalSpace Rental Plan
     */
    public function rentalSpaceRentalPlan():BelongsTo
    {
        return $this->belongsTo(RentalSpaceRentalPlan::class, 'rental_plan_id');
    }
}
