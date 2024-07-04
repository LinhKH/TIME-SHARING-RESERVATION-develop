<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationOrderItem extends Model
{
    use HasFactory;

    protected $table = 'reservation_order_item';
    protected $fillable = [
        'id',
        'people_count',
        'per_person_price',
        'per_person_price_with_fraction',
        'rental_interval_id',
        'rental_slot_id',
        'reservation_id',
        'tenancy_price',
        'tenancy_price_with_fraction',
        'total_price_sans_tax',
        'total_price_sans_tax_with_fraction',
        'created_at',
        'updated_at'
    ];

}
