<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalSpaceSearchEquipmentInformation extends Model
{
    use HasFactory;

    protected $table = 'rental_space_search_equipment_information';
    protected $fillable = [
        'id',
        'rental_space_equipment_information_id',
        'rental_space_id',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;

}
