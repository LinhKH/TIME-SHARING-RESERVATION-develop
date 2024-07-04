<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrackingLink extends Model
{
    use HasFactory;

    protected $table = 'tracking_link';
    protected $fillable = [
        'id',
        'entity_id',
        'name',
        'tracking_code',
        'type'
    ];

    /**
     * RelationShip rental_space
     *
     * @return BelongsTo
     */
    public function rentalSpace(): BelongsTo
    {
        return $this->belongsTo(RentalSpace::class, 'entity_id');

    }
}
