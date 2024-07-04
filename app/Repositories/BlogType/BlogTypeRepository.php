<?php


namespace App\Repositories\BlogType;

use App\Models\BlogType;
use App\Repositories\AbstractBaseRepository;

class BlogTypeRepository extends AbstractBaseRepository implements BlogTypeInterface
{
    public function __construct(BlogType $model)
    {
        parent::__construct($model);
    }

}

