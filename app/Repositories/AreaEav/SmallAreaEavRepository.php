<?php

namespace App\Repositories\AreaEav;

use App\Models\AreaGroupEav;
use App\Repositories\AbstractBaseRepository;

class SmallAreaEavRepository extends AbstractBaseRepository implements SmallAreaEavInterface
{
    public function __construct(AreaGroupEav $model)
    {
        parent::__construct($model);
    }
}
