<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class RentalSpaceUsePurposeImage extends Model
{
    use Uuids;
    use HasFactory;

    protected $table = 'rental_space_use_purpose_image';
    protected $fillable = [
        'id',
        'creation_time',
        'extension',
        'height',
        'length',
        'name',
        'parent_id',
        's3key',
        'width',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;

}
