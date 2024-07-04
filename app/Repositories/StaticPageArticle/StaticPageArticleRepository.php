<?php

namespace App\Repositories\StaticPageArticle;

use App\Models\StaticPageArticle;
use App\Repositories\AbstractBaseRepository;

class StaticPageArticleRepository extends AbstractBaseRepository implements StaticPageArticleInterface
{
    public function __construct(StaticPageArticle $model)
    {
        parent::__construct($model);
    }

}
