<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaticPageArticleEav extends Model
{
    use HasFactory;

    protected $table = 'static_page_article_eav';
    protected $fillable = [
        'id',
        'attribute',
        'namespace',
        'type',
        'value',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;

}
