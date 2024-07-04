<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignImage extends Model
{
    use HasFactory;

    protected $table = 'campaign_image';
    protected $fillable = [
        'id',
        'parent_id',
        'order_number',
        'width',
        'height',
        'length',
        'extension',
        's3key',
        'creation_time',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;
}
