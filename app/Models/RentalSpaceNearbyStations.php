<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RentalSpaceNearbyStations extends Model
{
    use HasFactory;

    protected $table = 'rental_space_nearby_stations';
    protected $fillable = [
        'id',
        'joined_stations',
        'ref',
        'rental_space_id',
        'transportation_station_id',
        'walking_duration',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;

    /**
     * Get the rental_space.
     */
    public function rentalSpace(): BelongsTo
    {
        return $this->belongsTo(RentalSpace::class, 'rental_space_id');
    }

    /**
     * Get the transportation Station.
     */
    public function transportationStation(): BelongsTo
    {
        return $this->belongsTo(TransportationStation::class, 'transportation_station_id');
    }

}
