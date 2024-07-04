<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RentalSpacePage extends Model
{
    use HasFactory;

    protected $table = 'rental_space_page';
    protected $fillable = [
        'id',
        'creation_time',
        'rental_space_id',
        'type',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;
    /**
     * Get the RentalSpacePageEav .
     */
    public function rentalSpacePageEav(): HasMany
    {
        return $this->hasMany(RentalSpacePageEav::class, 'namespace');
    }

    /**
     * Get the rental_space .
     */
    public function rentalSpace(): BelongsTo
    {
        return $this->BelongsTo(RentalSpace::class, 'rental_space_id');
    }
}
