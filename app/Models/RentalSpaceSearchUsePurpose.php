<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalSpaceSearchUsePurpose extends Model
{
    use HasFactory;

    protected $table = 'rental_space_search_use_purpose';
    protected $fillable = [
        'id',
        'rental_space_id',
        'rental_space_use_purpose_id',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;

}
