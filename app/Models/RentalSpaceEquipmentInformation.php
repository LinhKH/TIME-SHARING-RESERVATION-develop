<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RentalSpaceEquipmentInformation extends Model
{
    use HasFactory;

    protected $table = 'rental_space_equipment_information';
    protected $fillable = [
        'id',
        'active',
        'category_id',
        'checkbox_label_type',
        'default_value',
        'frequently_used',
        'legacy_id',
        'order_number',
        'parent_id',
        'required',
        'string_id',
        'type',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;

    /**
     * Get the rental_space_equipment_information_eav .
     */
    public function rentalSpaceEquipmentInformationEav(): HasMany
    {
        return $this->hasMany(RentalSpaceEquipmentInformationEav::class, 'namespace');
    }

    /**
     * Get the rental_space_equipment_information_image .
     */
    public function rentalSpaceEquipmentInformationImage(): HasMany
    {
        return $this->hasMany(RentalSpaceEquipmentInformationImage::class, 'parent_id');
    }
}
