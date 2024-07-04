<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalSpaceSyncLock extends Model
{
    use HasFactory;

    protected $table = 'rental_space_sync_lock';
    protected $fillable = [
        'id',
        'creation_time',
        'rental_space_id',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;

}
