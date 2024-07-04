<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RentalSpaceCompilationImage extends Model
{
    use HasFactory;

    protected $table = 'rental_space_compilation_image';
    protected $fillable = [
        'id',
        'creation_time',
        'extension',
        'height',
        'length',
        'name',
        'parent_id',
        's3key',
        'type',
        'width',
        'created_at',
        'updated_at',
    ];

    public $timestamps = true;

    public $incrementing = false;

    /**
     * RelationShip rental_space_compilation
     *
     * @return BelongsTo
     */
    public function rentalSpaceCompilation(): BelongsTo
    {
        return $this->belongsTo(RentalSpaceCompilation::class, 'parent_id');

    }

}
