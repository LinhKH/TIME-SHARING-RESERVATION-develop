<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalSpaceUsePurposeEav extends Model
{
    use HasFactory;

    protected $table = 'rental_space_use_purpose_eav';
    protected $fillable = [
        'id',
        'attribute',
        'namespace',
        'type',
        'value',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;

}
