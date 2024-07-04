<?php


namespace App\Repositories\Blog;

use App\Models\Blog;
use App\Repositories\AbstractBaseRepository;

class BlogRepository extends AbstractBaseRepository implements BlogInterface
{
    public function __construct(Blog $model)
    {
        parent::__construct($model);
    }

}

