<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalSlotProhibitionRule extends Model
{
    use HasFactory;

    protected $table = 'rental_slot_prohibition_rule';
    protected $fillable = [
        'id',
        'day_ident',
        'type',
        'google_event_id',
        'rental_interval_id',
        'rental_slot_id',
        'reservation_id',
        'created_at',
        'updated_at'
    ];
    public $timestamps = true;
}
