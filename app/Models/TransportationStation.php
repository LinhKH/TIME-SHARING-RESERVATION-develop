<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TransportationStation extends Model
{
    use HasFactory;

    public const BUS = 'bus';
    public const MONORAIL = 'monorail';
    public const SUBWAY = 'subway';
    public const TRAIN = 'train';
    public const TROLLEYBUS = 'trolleybus';
    public const TRAM = 'tram';

    protected $table = 'transportation_station';
    protected $fillable = [
        'id',
        'bus',
        'string_id',
        'route_id',
        'latitude',
        'longitude',
        'order_number',
        'monorail',
        'subway',
        'train',
        'tram',
        'trolleybus',
        'wheelchair',
        'ref',
        'osm_id',
        'station',
        'platform',
        'platforms'
    ];

    /**
     * RelationShip transportation Route Stations
     *
     * @return HasMany
     */
    public function transportationRouteStations(): HasMany
    {
        return $this->hasMany(TransportationRouteStations::class, 'station_id');

    }

    /**
     * RelationShip transportation Route Stations
     *
     * @return HasMany
     */
    public function transportationStationEav(): HasMany
    {
        return $this->hasMany(TransportationStationEav::class, 'namespace');

    }

    /**
     * Get the Rental Space Nearby Stations.
     */
    public function rentalSpaceNearbyStations(): HasMany
    {
        return $this->hasMany(RentalSpaceNearbyStations::class, 'transportation_station_id');
    }
}
