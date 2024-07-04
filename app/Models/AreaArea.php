<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AreaArea extends Model
{
    use HasFactory;

    protected $table = 'area_area';
    protected $fillable = [
        'id',
        'title__en',
        'title__ja',
        'title__ja_kana',
        'identifier',
        'legacy_id',
        'parent_id',
        'order_number',
        'active',
        'address_specifier',
        'creationTime',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;

    protected $casts = [
        'created_at'  => 'date:Y-m-d H:i',
        'updated_at' => 'date:Y-m-d H:i',
    ];

    public function scopeGetLatestId()
    {
        return AreaArea::latest('id')->first();
    }

    /**
     * Get the areaAreaEavs .
     */
    public function areaAreaEavs(): HasMany
    {
        return $this->hasMany(AreaAreaEav::class, 'namespace', 'id');
    }
}
