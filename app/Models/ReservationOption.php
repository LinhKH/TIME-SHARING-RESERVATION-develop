<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationOption extends Model
{
    use HasFactory;

    protected $table = 'reservation_option';
    protected $fillable = [
        'id',
        'maximum_order_quantity',
        'quantity',
        'reservation_id',
        'reservation_option_type_id',
        'singular_price_of_sale',
        'singular_price_of_sale_with_fraction',
        'title',
        'unit_type',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;

}
