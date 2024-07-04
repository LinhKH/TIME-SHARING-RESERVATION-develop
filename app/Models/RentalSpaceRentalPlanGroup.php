<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RentalSpaceRentalPlanGroup extends Model
{

    use HasFactory;

    protected $table = 'rental_space_rental_plan_group';
    protected $fillable = [
        'id',
        'maximum_simultaneous_people',
        'maximum_simultaneous_reservations',
        'rental_space_id',
        'status',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;

    /**
     * Relationship RentalSpace Rental Plan Group Eav
     */
    public function rentalSpaceRentalPlanGroupEav():HasMany
    {
        return $this->hasMany(RentalSpaceRentalPlanGroupEav::class, 'namespace');
    }

    /**
     * Relationship RentalSpace RentalPlan - RentalPlanGroup
     */
    public function rentalSpaceRentalPlanRentalPlanGroup():HasMany
    {
        return $this->hasMany(RentalSpaceRentalPlanRentalPlanGroup::class, 'rental_plan_group_id');
    }
}
