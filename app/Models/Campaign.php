<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $table = 'campaign';
    protected $fillable = [
        'id',
        'alias',
        'title',
        'pr_description',
        'valid_from',
        'valid_to',
        'published',
        'coupon_id',
        'confirm_day_ident',
        'show_at_index',
        'space_index_url',
        'show_alt',
        'type',
        'keywords',
        'use_purpose_category_ids',
        'equipment_information',
        'prefectures',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;

}
