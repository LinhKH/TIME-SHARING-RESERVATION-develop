<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaAreaImageEav extends Model
{
    use HasFactory;

    protected $table = 'area_area_image_eav';
    protected $fillable = [
        'id',
        'attribute',
        'namespace',
        'type',
        'value',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;

}
