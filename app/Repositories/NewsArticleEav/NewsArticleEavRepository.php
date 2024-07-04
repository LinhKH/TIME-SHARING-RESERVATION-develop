<?php

namespace App\Repositories\NewsArticleEav;

use App\Models\NewsArticleEav;
use App\Repositories\AbstractBaseRepository;

class NewsArticleEavRepository extends AbstractBaseRepository implements NewsArticleEavInterface
{
    public function __construct(NewsArticleEav $model)
    {
        parent::__construct($model);
    }


    public function updateOneByAttribute($Condition,$data)
    {

    }

}
