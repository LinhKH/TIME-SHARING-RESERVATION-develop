<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationOptionTypeCategory extends Model
{
    use HasFactory;

    protected $table = 'reservation_option_type_category';
    protected $fillable = [
        'id',
        'order_number',
        'rental_space_id',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;

}
