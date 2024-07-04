<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemConfig extends Model
{
    use HasFactory;

    protected $table = 'system_config';
    protected $fillable = [
        'id'
    ];

    public $incrementing = false;
    public $timestamps = true;
}
