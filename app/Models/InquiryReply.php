<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel as Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class InquiryReply extends Eloquent
{
    use HasFactory;

    protected $table = 'inquiry_reply';

    protected $fillable = [
        'id',
        'inquiry_id',
        'customer_id',
        'user_id',
        'guest_information',
        'description',
        'creation_time',
        'is_read',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;

    protected $casts = [
        'guest_information' => 'json',
        'created_at'  => 'date:Y-m-d H:i',
        'updated_at' => 'date:Y-m-d H:i',
    ];

    /**
     * Get the user .
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
