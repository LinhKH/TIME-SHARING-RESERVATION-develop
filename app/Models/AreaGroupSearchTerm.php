<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaGroupSearchTerm extends Model
{
    use HasFactory;

    protected $table = 'area_group_search_term';
    protected $fillable = [
        'area_group_id',
        'area_group_text',
        'type',
        'created_at',
        'updated_at',
    ];

    public $timestamps = true;
}
