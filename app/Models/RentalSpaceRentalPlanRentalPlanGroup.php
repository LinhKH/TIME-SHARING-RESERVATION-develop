<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RentalSpaceRentalPlanRentalPlanGroup extends Model
{
    use HasFactory;

    protected $table = 'rental_space_rental_plan_rental_plan_group';
    protected $fillable = [
        'id',
        'rental_plan_group_id',
        'rental_plan_id',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;

    /**
     * Relationship RentalSpace Rental Plan
     */
    public function rentalSpacePlan():BelongsTo
    {
        return $this->belongsTo(RentalSpaceRentalPlan::class, 'rental_plan_id');
    }

    /**
     * Relationship RentalSpace Rental Plan Group
     */
    public function rentalSpacePlanGroup():BelongsTo
    {
        return $this->belongsTo(RentalSpaceRentalPlanGroup::class, 'rental_plan_group_id');
    }
}
