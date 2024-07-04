<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationOptionTypeReservationOptionTypeImage extends Model
{
    use HasFactory;

    protected $table = 'reservation_option_type_reservation_option_type_image';
    protected $fillable = [
        'id',
        'created_at',
        'updated_at',
    ];

    public $timestamps = true;

}
