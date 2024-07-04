<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RentalSpaceRentalPlan extends Model
{
    use HasFactory;

    const ACTIVE = 'active';
    protected $table = 'rental_space_rental_plan';
    protected $fillable = [
        'id',
        'allowing_multi_booking',
        'bank_account_id',
        'handling_fee_percentage',
        'min_contiguous_duration_minutes',
        'rental_plan_group_id',
        'rental_space_id',
        'requiring_contiguous',
        'status',
        'type',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;

    /**
     * RelationShip Rental Interval
     * @return HasMany
     */
    public function rentalSpaceRentalInterval(): HasMany
    {
        return $this->hasMany(RentalSpaceRentalInterval::class, 'rental_plan_id');
    }

    /**
     * RelationShip Rental Interval
     * @return HasMany
     */
    public function rentalSpaceRentalPlanEav(): HasMany
    {
        return $this->hasMany(RentalSpaceRentalPlanEav::class, 'namespace');
    }

    /**
     * Relationship RentalSpace Rental Plan
     */
    public function rentalSpace(): BelongsTo
    {
        return $this->belongsTo(RentalSpace::class, 'rental_space_id');
    }

    /**
     * RelationShip Rental Interval
     * @return HasMany
     */
    public function rentalSpaceRentalPlanImage(): HasMany
    {
        return $this->hasMany(RentalSpaceRentalPlanImage::class, 'parent_id');
    }

    /**
     * Relationship RentalSpace RentalPlan - RentalPlanGroup
     */
    public function rentalSpaceRentalPlanRentalPlanGroup(): HasMany
    {
        return $this->hasMany(RentalSpaceRentalPlanRentalPlanGroup::class, 'rental_plan_id');
    }

    /**
     * Get the rental_slot_cache_entry .
     */
    public function rentalSlotCacheEntry(): HasMany
    {
        return $this->hasMany(RentalSlotCacheEntry::class, 'rental_plan_id');
    }
}
