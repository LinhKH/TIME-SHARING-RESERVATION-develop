<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterLinkCategory extends Model
{
    use HasFactory;

    protected $table = 'footer_links_category';
    protected $fillable = [
        'id',
        'order_number',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;

}
