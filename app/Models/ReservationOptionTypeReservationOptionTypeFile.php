<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationOptionTypeReservationOptionTypeFile extends Model
{
    use HasFactory;

    protected $table = 'reservation_option_type_reservation_option_type_file';
    protected $fillable = [
        'id',
        'created_at',
        'updated_at',
    ];

    public $timestamps = true;

}
