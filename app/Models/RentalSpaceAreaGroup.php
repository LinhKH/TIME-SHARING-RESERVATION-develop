<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RentalSpaceAreaGroup extends Model
{
    use HasFactory;

    protected $table = 'rental_space_area_group';
    protected $fillable = [
        'id',
        'area_group_id',
        'rental_space_id',
        'created_at',
        'updated_at',
    ];

    public $timestamps = true;

    /**
     * RelationShip RentalSpace
     *
     * @return BelongsTo
     */
    public function rentalSpace(): BelongsTo
    {
        return $this->belongsTo(RentalSpace::class, 'rental_space_id');

    }

    /**
     * RelationShip area_group
     *
     * @return BelongsTo
     */
    public function areaGroup(): BelongsTo
    {
        return $this->belongsTo(AreaGroup::class, 'area_group_id');

    }
}
