<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TsCampaign extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ts_campaign';

    protected $guarded = [];

    protected $casts = [
        'created_at'  => 'date:Y-m-d H:i',
        'updated_at' => 'date:Y-m-d H:i',
    ];

    /**
     * Get the ts_campaign_spaces .
     */
    public function tsCampaignSpace(): HasMany
    {
        return $this->hasMany(TsCampaignSpace::class,  'ts_campaign_id');
    }

    /**
     * Filter Name
     */
    public function scopeFilterTitle($query, $request)
    {
        if (isset($request['title'])) {
            $query->where('title', 'like', "%{$request['title']}%");
        }

        return $query;
    }
}
