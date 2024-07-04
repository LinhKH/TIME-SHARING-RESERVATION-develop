<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterLink extends Model
{
    use HasFactory;

    protected $table = 'footer_links';
    protected $fillable = [
        'id',
        'order_number',
        'category_id',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;

}
