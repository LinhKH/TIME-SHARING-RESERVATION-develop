<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogItem extends Model
{
    use HasFactory;

    protected $table = 'blog_item';
    protected $fillable = [
        'blog_id',
        'subtitle',
        'img',
        'description',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;

}
