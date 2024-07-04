<?php


namespace App\Repositories\BlogItem;

use App\Models\BlogItem;
use App\Repositories\AbstractBaseRepository;

class BlogItemRepository extends AbstractBaseRepository implements BlogItemInterface
{
    public function __construct(BlogItem $model)
    {
        parent::__construct($model);
    }

}

