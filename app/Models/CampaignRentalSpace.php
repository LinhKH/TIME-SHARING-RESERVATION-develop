<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignRentalSpace extends Model
{
    use HasFactory;

    protected $table = 'campaign_rental_space';
    protected $fillable = [
        'id',
        'campaign_id',
        'rental_space_id',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;
}
