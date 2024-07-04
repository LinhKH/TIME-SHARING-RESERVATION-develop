<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RentalSpaceDirectionsStationImageEav extends Model
{
    use HasFactory;

    protected $table = 'rental_space_directions_station_image_eav';
    protected $fillable = [
        'id',
        'attribute',
        'namespace',
        'type',
        'value',
    ];

    public $timestamps = true;

    /**
     * RelationShip rental_space_directions_station_image
     *
     * @return BelongsTo
     */
    public function rentalSpaceDirectionsStationImage(): BelongsTo
    {
        return $this->belongsTo(RentalSpaceDirectionsStationImage::class, 'namespace');

    }

}
