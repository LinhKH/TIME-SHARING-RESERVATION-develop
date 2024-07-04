<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RentalSpacePageEav extends Model
{
    use HasFactory;

    protected $table = 'rental_space_page_eav';
    protected $fillable = [
        'id',
        'attribute',
        'namespace',
        'type',
        'value',
    ];

    public $timestamps = true;

    /**
     * RelationShip RentalSpacePage
     *
     * @return BelongsTo
     */
    public function rentalSpacePage(): BelongsTo
    {
        return $this->belongsTo(RentalSpacePage::class, 'namespace');

    }
}
