<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransportationRouteEav extends Model
{
    use HasFactory;

    protected $table = 'transportation_route_eav';
    protected $fillable = [
        'id',
        'attribute',
        'namespace',
        'type',
        'value'
    ];


    /**
     * RelationShip Transportation Route
     *
     * @return BelongsTo
     */
    public function transportationRoute(): BelongsTo
    {
        return $this->belongsTo(TransportationRoute::class, 'namespace');
    }
}
