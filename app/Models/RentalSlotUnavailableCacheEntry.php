<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RentalSlotUnavailableCacheEntry extends Model
{
    use HasFactory;

    protected $table = 'rental_slot_unavailable_cache_entry';
    protected $fillable = [
        'id',
        'available_seats_count',
        'day_ident',
        'most_generous_reservation_window_close_time',
        'per_person_price',
        'rental_interval_id',
        'rental_space_id',
        'status',
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
}
