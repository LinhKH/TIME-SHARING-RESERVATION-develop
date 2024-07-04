<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RentalSpaceEquipmentInformationEav extends Model
{
    use HasFactory;

    protected $table = 'rental_space_equipment_information_eav';
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
     * RelationShip RentalSpaceEquipmentInformation
     *
     * @return BelongsTo
     */
    public function RentalSpaceEquipmentInformation(): BelongsTo
    {
        return $this->belongsTo(RentalSpaceEquipmentInformation::class, 'namespace');

    }
}
