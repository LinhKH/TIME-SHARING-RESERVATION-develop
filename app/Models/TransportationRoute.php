<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TransportationRoute extends Model
{
    use HasFactory;

    protected $table = 'transportation_route';
    protected $fillable = [
        'id',
        'string_id',
        'type',
        'latitude',
        'longitude',
        'order_number',
        'colour',
        'roundtrip',
        'wheelchair',
        'osm_id',
        'route'
    ];

    /**
     * RelationShip transportation Route Stations
     *
     * @return HasMany
     */
    public function transportationRouteStations(): HasMany
    {
        return $this->hasMany(TransportationRouteStations::class, 'route_id');

    }

    /**
     * RelationShip transportation Route Eav
     *
     * @return HasMany
     */
    public function transportationRouteEav(): HasMany
    {
        return $this->hasMany(TransportationRouteEav::class, 'namespace');

    }
}
