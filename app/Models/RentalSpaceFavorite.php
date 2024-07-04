<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RentalSpaceFavorite extends Model
{

    use HasFactory;

    protected $table = 'rental_space_favorite';
    protected $fillable = [
        'id',
        'creation_time',
        'customer_id',
        'rental_space_id',
        'created_at',
        'updated_at',
    ];

    public $timestamps = true;

    /**
     * RelationShip customer
     *
     * @return BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');

    }

    /**
     * RelationShip rental_space
     *
     * @return BelongsTo
     */
    public function rentalSpace(): BelongsTo
    {
        return $this->belongsTo(RentalSpace::class, 'rental_space_id');

    }
}
