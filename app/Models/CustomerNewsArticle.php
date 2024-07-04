<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerNewsArticle extends Model
{
    use HasFactory;

    protected $table = 'customer_news_article';
    protected $fillable = [
        'id',
        'active',
        'creationTime',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;

}
