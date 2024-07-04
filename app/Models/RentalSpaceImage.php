<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RentalSpaceImage extends Model
{
    use HasFactory;

    protected $table = 'rental_space_image';
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
     * Get the RentalSpaceImageEav .
     */
    public function rentalSpaceImageEav(): HasMany
    {
        return $this->hasMany(RentalSpaceImageEav::class, 'namespace');
    }

    /**
     * Get the rental_space .
     */
    public function rentalSpace(): BelongsTo
    {
        return $this->BelongsTo(RentalSpace::class, 'parent_id');
    }
}
