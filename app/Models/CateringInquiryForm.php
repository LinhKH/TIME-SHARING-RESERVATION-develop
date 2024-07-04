<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CateringInquiryForm extends Model
{
    use HasFactory;

    protected $table = 'catering_inquiry_form';
    protected $fillable = [
        'id',
        'creation_time',
        'type',
        'name',
        'kana',
        'email',
        'phonenumber',
        'organization_name',
        'venue_address',
        'planning_date',
        'planning_date_include_time',
        'number_of_people',
        'badget_per_person',
        'usage_type',
        'menu',
        'notes',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;
}
