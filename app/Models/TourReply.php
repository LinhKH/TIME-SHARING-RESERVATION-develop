<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TourReply extends Model
{
    use HasFactory;

    protected $table = 'tour_reply';

    protected $fillable = [
        'id',
        'tour_id',
        'customer_id',
        'user_id',
        'description',
        'creation_time',
        'is_read',
    ];

    protected $casts = [
        'created_at' => 'date:Y-m-d H:i',
        'updated_at' => 'date:Y-m-d H:i',
    ];

}
