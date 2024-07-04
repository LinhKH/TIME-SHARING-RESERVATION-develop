<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RentalSpacePanoramaImage extends Model
{
    use HasFactory;

    protected $table = 'rental_space_panorama_image';
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
     * Relation to Panorama image Eav
     * @return HasMany
     */
    public function panoramaImageEav(): HasMany
    {
        return $this->hasMany(RentalSpacePanoramaImageEav::class, 'namespace');
    }

}
