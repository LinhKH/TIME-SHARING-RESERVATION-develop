<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RentalSpaceFacadeImage extends Model
{
    use HasFactory;

    protected $table = 'rental_space_facade_image';
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
     * Get the RentalSpaceFacadeImageEav .
     */
    public function rentalSpaceFacadeImageEav(): HasMany
    {
        return $this->hasMany(RentalSpaceFacadeImageEav::class, 'namespace');
    }
}
