<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RentalSpaceCompilationEav extends Model
{

    use HasFactory;

    protected $table = 'rental_space_compilation_eav';
    protected $fillable = [
        'id',
        'attribute',
        'namespace',
        'type',
        'value',
    ];

    public $timestamps = true;

    /**
     * RelationShip rental_space_compilation
     *
     * @return BelongsTo
     */
    public function rentalSpaceCompilation(): BelongsTo
    {
        return $this->belongsTo(RentalSpaceCompilation::class, 'namespace');

    }

}
