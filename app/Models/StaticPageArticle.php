<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel as Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StaticPageArticle extends Eloquent
{
    use Uuids;
    use HasFactory;

    protected $table = 'static_page_article';
    protected $fillable = [
        'id',
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
        return $this->belongsTo(StaticPageArticle::class, 'namespace');

    }

    /**
     * Get the rental_space_email_message_eav .
     */
    public function newsEav(): HasMany
    {
        return $this->hasMany(StaticPageArticleEav::class, 'namespace');
    }
}
