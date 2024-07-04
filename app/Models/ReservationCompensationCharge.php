<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationCompensationCharge extends Model
{
    use HasFactory;

    protected $table = 'reservation_compensation_charge';
    protected $fillable = [
        'id',
        'amount',
        'creation_time',
        'note',
        'payment_webpay_charge_id',
        'reservation_id',
        'created_at',
        'updated_at',
    ];

    public $timestamps = true;

}
