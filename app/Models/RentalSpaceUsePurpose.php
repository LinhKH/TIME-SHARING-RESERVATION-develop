<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalSpaceUsePurpose extends Model
{
    use HasFactory;

    protected $table = 'rental_space_use_purpose';
    protected $fillable = [
        'id',
        'active',
        'category_id',
        'equipment_information_icons_ids',
        'equipment_information_ids',
        'equipment_information_ids_mobile',
        'legacy_id',
        'order_number',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;

     /**
     * Get the rentalSpaceUsePurposeEavs .
     */
    public function rentalSpaceUsePurposeEavs()
    {
        return $this->hasMany(RentalSpaceUsePurposeEav::class, 'namespace', 'id');
    }
}
