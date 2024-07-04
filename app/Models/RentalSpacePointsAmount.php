<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalSpacePointsAmount extends Model
{
    use HasFactory;

    protected $table = 'rental_space_points_amount';
    protected $fillable = [
        'id',
        'data_high_limit',
        'data_low_limit',
        'item',
        'points',
        'sub_type',
        'type',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;

}
