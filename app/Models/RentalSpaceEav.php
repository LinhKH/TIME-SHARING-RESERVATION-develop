<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class RentalSpaceEav extends Model
{
    use HasFactory;

    protected $table = 'rental_space_eav';

    protected $fillable = [
        'id',
        'attribute',
        'namespace',
        'type',
        'type_step',
        'value',
    ];

    public $timestamps = true;

    /**
     * Get the rental_space_eav.
     */
    public function rentalSpace(): BelongsTo
    {
        return $this->belongsTo(RentalSpace::class, 'namespace');
    }
}
