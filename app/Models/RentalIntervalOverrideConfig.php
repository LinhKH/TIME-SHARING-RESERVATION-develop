<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RentalIntervalOverrideConfig extends Model
{
    use HasFactory;

    protected $table = 'rental_interval_override_config';
    protected $fillable = [
        'id',
        'day_ident',
        'denied',
        'maximum_simultaneous_people',
        'maximum_simultaneous_reservations',
        'note',
        'per_person_price',
        'per_person_price_with_fraction',
        'profit_sans_tax',
        'rental_interval_id',
        'tax_percentage',
        'tenancy_price',
        'tenancy_price_with_fraction',
        'created_at',
        'updated_at',
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
}
