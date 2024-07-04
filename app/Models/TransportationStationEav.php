<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransportationStationEav extends Model
{
    use HasFactory;

    protected $table = 'transportation_station_eav';
    protected $fillable = [
        'id',
        'attribute',
        'namespace',
        'type',
        'value'
    ];


    /**
     * RelationShip Transportation Station
     *
     * @return BelongsTo
     */
    public function transportationStation(): BelongsTo
    {
        return $this->belongsTo(TransportationStation::class, 'namespace');
    }
}
