<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReservationOptionTypeReservationOptionType extends Model
{

    use HasFactory;

    protected $table = 'reservation_option_type_reservation_option_type';
    protected $fillable = [
        'id',
        'active',
        'category_id',
        'maximum_order_quantity',
        'minimum_order_quantity',
        'order_number',
        'rental_space_id',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;

    /**
     * Relation to Rental Space
     */
    public function rentalSpace(): BelongsTo
    {
        return $this->belongsTo(RentalSpace::class, 'rental_space_id');
    }

    /**
     * Relation to Reservation Option Type Reservation Option Type Eav
     */
    public function reservationOptionTypeEav(): HasMany
    {
        return $this->hasMany(ReservationOptionTypeReservationOptionTypeEav::class, 'namespace');
    }
}
