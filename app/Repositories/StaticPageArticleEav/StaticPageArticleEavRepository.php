<?php

namespace App\Repositories\StaticPageArticleEav;

use App\Models\StaticPageArticleEav;
use App\Repositories\AbstractBaseRepository;

class StaticPageArticleEavRepository extends AbstractBaseRepository implements StaticPageArticleEavInterface
{
    public function __construct(StaticPageArticleEav $model)
    {
        parent::__construct($model);
    }

}
