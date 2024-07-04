<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationOptionTypeCategoryEav extends Model
{

    use HasFactory;

    protected $table = 'reservation_option_type_category_eav';
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
