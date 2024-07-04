<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalSpaceAdDayStats extends Model
{
    use HasFactory;

    protected $table = 'rental_space_ad_day_stats';
    protected $fillable = [
        'id',
        'ads_section',
        'clicks_count',
        'day_ident',
        'inquiries_count',
        'reservations_count',
        'views_count',
        'rental_space_id',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;
}
