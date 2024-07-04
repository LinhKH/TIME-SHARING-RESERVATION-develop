<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationLock extends Model
{
    use HasFactory;

    protected $table = 'reservation_lock';
    protected $fillable = [
        'id',
        'creation_time',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;

}
