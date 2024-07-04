<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaAreaImage extends Model
{
    use HasFactory;

    protected $table = 'area_area_image';
    protected $fillable = [
        'id',
        'created_at',
        'updated_at',
    ];

    public $timestamps = true;

}
