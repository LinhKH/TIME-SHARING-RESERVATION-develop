<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalSpaceSearchCoordinate extends Model
{
    use HasFactory;

    protected $table = 'rental_space_search_coordinate';
    protected $fillable = [
        'rental_space_id',
        'geom',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;
}
