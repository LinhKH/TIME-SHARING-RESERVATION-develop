<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RentalSpacePanoramaImageEav extends Model
{

    use HasFactory;

    protected $table = 'rental_space_panorama_image_eav';
    protected $fillable = [
        'id',
        'attribute',
        'namespace',
        'type',
        'value',
    ];

    public $timestamps = true;

    /**
     * Relation to Panorama Image
     *
     * @return BelongsTo
     */
    public function panoramaImage(): BelongsTo
    {
        return $this->belongsTo(RentalSpacePanoramaImage::class, 'namespace');
    }
}
