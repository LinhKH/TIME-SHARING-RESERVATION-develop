<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RentalSpaceEquipmentInformationImage extends Model
{
    use Uuids;
    use HasFactory;

    protected $table = 'rental_space_equipment_information_image';
    protected $fillable = [
        'id',
        'creation_time',
        'extension',
        'height',
        'length',
        'name',
        'parent_id',
        's3key',
        'width',
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
        return $this->belongsTo(RentalSpaceEquipmentInformation::class, 'parent_id');

    }
}
