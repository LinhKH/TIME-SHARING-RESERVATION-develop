<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalSpaceSearchKeyword extends Model
{
    use HasFactory;

    protected $table = 'rental_space_search_keyword';
    protected $fillable = [
        'rental_space_id',
        'rental_space_text',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;

}
