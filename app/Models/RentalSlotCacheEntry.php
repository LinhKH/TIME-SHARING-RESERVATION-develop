<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RentalSlotCacheEntry extends Model
{
    use HasFactory;

    protected $table = 'rental_slot_cache_entry';
    protected $fillable = [
        'id',
        'available_seats_count',
        'day_ident',
        'end_time',
        'most_generous_reservation_window_close_time',
        'per_person_price',
        'rental_interval_id',
        'rental_plan_id',
        'rental_space_id',
        'start_time',
        'tenancy_price',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;
    public $incrementing = false;
    /**
     * RelationShip rentalSpaceRentalInterval
     *
     * @return BelongsTo
     */
    public function rentalSpaceRentalInterval(): BelongsTo
    {
        return $this->belongsTo(RentalSpaceRentalInterval::class, 'rental_interval_id');

    }

    /**
     * RelationShip RentalSpace
     *
     * @return BelongsTo
     */
    public function rentalSpace(): BelongsTo
    {
        return $this->belongsTo(RentalSpace::class, 'rental_space_id');

    }

    /**
     * RelationShip Plan
     *
     * @return BelongsTo
     */
    public function rentalPlan(): BelongsTo
    {
        return $this->belongsTo(RentalSpaceRentalPlan::class, 'rental_plan_id');

    }
}
