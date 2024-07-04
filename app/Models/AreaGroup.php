<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AreaGroup extends Model
{
    use HasFactory;

    protected $table = 'area_group';
    protected $fillable = [
        'id',
        'title__en',
        'title__ja',
        'title__ja_kana',
        'identifier',
        'parent_id',
        'order_number',
        'active',
        'address_specifier',
        'creationTime',
        'created_at',
        'updated_at',
    ];

    public $timestamps = true;

    protected $casts = [
        'created_at'  => 'date:Y-m-d H:i',
        'updated_at' => 'date:Y-m-d H:i',
    ];

    /**
     * Get the rental_space_area_group .
     */
    public function rentalSpaceAreaGroup(): HasMany
    {
        return $this->hasMany(RentalSpaceAreaGroup::class, 'area_group_id');
    }

    /**
     * Get the area_group .
     */
    public function areaGroups(): HasMany
    {
        return $this->hasMany(AreaGroup::class, 'parent_id');
    }

    /**
     * Get the areaGroupEavs .
     */
    public function areaGroupEavs(): HasMany
    {
        return $this->hasMany(AreaGroupEav::class, 'namespace', 'id');
    }

    public function scopeGetLatestId()
    {
        return AreaGroup::latest('id')->first();
    }
}
