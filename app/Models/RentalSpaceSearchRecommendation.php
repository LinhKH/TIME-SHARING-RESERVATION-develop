<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalSpaceSearchRecommendation extends Model
{

    use HasFactory;

    protected $table = 'rental_space_search_recommendation';
    protected $fillable = [
        'rental_space_id',
        'recommendationInformation__hasHpEmbedded',
        'recommendationInformation__hasCoverage',
        'recommendationInformation__featured2',
        'recommendationInformation__featured3',
        'recommendationInformation__featured4',
        'recommendationInformation__featured5',
        'recommendationInformation__featured6',
        'recommendationInformation__featured7',
        'recommendationInformation__featured8',
        'recommendationInformation__featured9',
        'recommendationInformation__featured10',
        'recommendationInformation__featured11',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;
}
