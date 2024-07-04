<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalSpaceSearchGeneral extends Model
{
    use HasFactory;

    protected $table = 'rental_space_search_general';
    protected $fillable = [
        'rental_space_id',
        'locationInformation__prefecture',
        'locationInformation__zip',
        'spaceInformation__exclusiveCheapestPrice',
        'spaceInformation__maximumCapacity',
        'spaceInformation__movie',
        'title__en',
        'title__ja',
        'titleKana',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;

}
