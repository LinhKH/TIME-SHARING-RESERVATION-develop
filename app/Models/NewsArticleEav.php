<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel as Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NewsArticleEav extends Eloquent
{

    use HasFactory;

    protected $table = 'news_article_eav';
    protected $fillable = [
        'id',
        'attribute',
        'namespace',
        'type',
        'value',
    ];

    public $timestamps = true;

    /**
     * RelationShip rental_space_compilation
     *
     * @return BelongsTo
     */
    public function newsArticle(): BelongsTo
    {
        return $this->belongsTo(NewsArticleEav::class, 'namespace');

    }

}
