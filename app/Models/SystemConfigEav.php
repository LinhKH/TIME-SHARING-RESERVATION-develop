<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemConfigEav extends Model
{
    use HasFactory;

    protected $table = 'system_config_eav';
    protected $fillable = [
        'id',
        'namespace',
        'attribute',
        'value',
        'type'
    ];

    public $timestamps = true;
}
