<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TsRollBanner extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'created_at'  => 'date:Y-m-d H:i',
        'updated_at' => 'date:Y-m-d H:i',
        'url' => 'json',
    ];

    /**
     * Filter Title
     */
    public function scopeFilterTitle($query, $request)
    {
        if (isset($request['title'])) {
            $query->where('title', 'like', "%{$request['title']}%");
        }

        return $query;
    }

    /**
     * Filter Date
     */
    public function scopeFilterDate($query, $request)
    {
        if (isset($request['created_at'])) {
            if (isset($request['created_at']['year'])) {
                $query->whereYear('created_at', $request['created_at']['year']);
            }
            if (isset($request['created_at']['month'])) {
                $query->whereMonth('created_at', $request['created_at']['month']);
            }
        }

        return $query;
    }
}
