<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RentalSpaceFloorPlanEav extends Model
{
    use HasFactory;

    protected $table = 'rental_space_floor_plan_eav';
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
     * RelationShip RentalSpaceFloorPlan
     *
     * @return BelongsTo
     */
    public function rentalSpaceFloorPlan(): BelongsTo
    {
        return $this->belongsTo(RentalSpaceFloorPlan::class, 'namespace');

    }

}
