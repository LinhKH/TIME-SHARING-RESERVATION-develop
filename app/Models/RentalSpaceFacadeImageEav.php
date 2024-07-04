<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RentalSpaceFacadeImageEav extends Model
{
    use HasFactory;

    protected $table = 'rental_space_facade_image_eav';
    protected $fillable = [
        'id',
        'attribute',
        'namespace',
        'type',
        'value',
    ];

    public $timestamps = true;

    /**
     * RelationShip RentalSpaceFacadeImage
     *
     * @return BelongsTo
     */
    public function rentalSpaceFacadeImage(): BelongsTo
    {
        return $this->belongsTo(RentalSpaceFacadeImage::class, 'namespace');
    }

}
