<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RentalSpaceRentalPlanImage extends Model
{
    use HasFactory;

    protected $table = 'rental_space_rental_plan_image';
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

    /**
     * Relationship RentalSpace Rental Plan
     */
    public function rentalSpacePlan():BelongsTo
    {
        return $this->belongsTo(RentalSpaceRentalPlan::class, 'parent_id');
    }
}
