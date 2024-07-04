<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RentalSpaceImageEav extends Model
{
    use HasFactory;

    protected $table = 'rental_space_image_eav';
    protected $fillable = [
        'id',
        'attribute',
        'namespace',
        'type',
        'value',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;

    /**
     * RelationShip RentalSpaceImage
     *
     * @return BelongsTo
     */
    public function rentalSpaceImage(): BelongsTo
    {
        return $this->belongsTo(RentalSpaceImage::class, 'namespace');

    }
}
