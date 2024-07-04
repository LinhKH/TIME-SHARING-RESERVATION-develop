<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TsNews extends Model
{
    use HasFactory;

    public const STATUS_ACTIVE = 0;
    public const STATUS_UN_ACTIVE = 1;

    protected $guarded = [];

    protected $casts = [
        'created_at' => 'date:Y-m-d H:i',
        'updated_at' => 'date:Y-m-d H:i',
    ];
}
