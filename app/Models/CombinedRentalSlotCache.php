<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CombinedRentalSlotCache extends Model
{
    use HasFactory;

    protected $table = 'combined_rental_slot_cache';
    protected $fillable = [
        '_id',
        'rental_space_id',
        'rental_plan_id',
        'day_ident',
        'start_time',
        'end_time',
        'numcontracts',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;

}
