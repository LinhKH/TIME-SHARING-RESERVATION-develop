<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalSpaceReview extends Model
{
    use HasFactory;

    protected $table = 'rental_space_review';
    protected $fillable = [
        'id',
        'creation_time',
        'customer_id',
        'depth',
        'lineage',
        'memo',
        'modification_time',
        'parent_id',
        'points',
        'rental_space_id',
        'review',
        'status',
        'subject',
        'user_id',
        'visit_month_ident',
        'created_at',
        'updated_at',
    ];

    public $timestamps = true;

}
