<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TsCategorySpace extends Model
{
    use HasFactory, SoftDeletes;

    public const TS_CATEGORY_SPACES_STATUS_ACTIVE = 0;
    public const TS_CATEGORY_SPACES_STATUS_DEACTIVE = 1;

    protected $guarded = [];

    protected $casts = [
        'created_at'  => 'date:Y-m-d H:i',
        'updated_at' => 'date:Y-m-d H:i',
    ];
}
