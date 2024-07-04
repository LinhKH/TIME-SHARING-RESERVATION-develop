<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RentalSpaceDirectionsStationImage extends Model
{
    use HasFactory;

    protected $table = 'rental_space_directions_station_image';
    protected $fillable = [
        'id',
        'creation_time',
        'extension',
        'height',
        'length',
        'order_number',
        'parent_id',
        's3key',
        'width',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;
    public $incrementing = false;

    /**
     * Get the rental_space_directions_station_image_eav .
     */
    public function rentalSpaceDirectionsStationImageEav(): HasMany
    {
        return $this->hasMany(RentalSpaceDirectionsStationImageEav::class, 'namespace');
    }


}
