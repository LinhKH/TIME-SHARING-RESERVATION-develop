<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel as Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NewsArticle extends Eloquent
{
    use HasFactory;

    protected $table = 'news_article';
    protected $fillable = [
        'id',
        'active',
        'creationTime',
        'created_at',
        'updated_at',
    ];

    public $timestamps = true;

    /**
     * RelationShip rental_space
     *
     * @return BelongsTo
     */
    public function news(): BelongsTo
    {
        return $this->belongsTo(NewsArticle::class, 'namespace');

    }

    /**
     * Get the rental_space_email_message_eav .
     */
    public function newsEav(): HasMany
    {
        return $this->hasMany(NewsArticleEav::class, 'namespace');
    }
}
