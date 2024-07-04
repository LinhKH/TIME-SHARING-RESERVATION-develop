<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RentalSpaceFloorPlan extends Model
{
    use HasFactory;

    protected $table = 'rental_space_floor_plan';
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
     * Get the RentalSpaceFloorPlanEav .
     */
    public function rentalSpaceFloorPlanEav(): HasMany
    {
        return $this->hasMany(RentalSpaceFloorPlanEav::class, 'namespace');
    }
}
