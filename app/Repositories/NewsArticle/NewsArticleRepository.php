<?php

namespace App\Repositories\NewsArticle;

use App\Models\NewsArticle;
use App\Repositories\AbstractBaseRepository;

class NewsArticleRepository extends AbstractBaseRepository implements NewsArticleInterface
{
    public function __construct(NewsArticle $model)
    {
        parent::__construct($model);
    }

}
