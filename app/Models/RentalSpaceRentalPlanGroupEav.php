<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RentalSpaceRentalPlanGroupEav extends Model
{

    use HasFactory;

    protected $table = 'rental_space_rental_plan_group_eav';
    protected $fillable = [
        'id',
        'attribute',
        'namespace',
        'type',
        'value',
    ];

    public $timestamps = true;

    /**
     * Relationship RentalSpace Rental Plan Group
     */
    public function rentalSpaceRentalPlanGroup():BelongsTo
    {
        return $this->belongsTo(RentalSpaceRentalPlanGroup::class, 'namespace');
    }
}
