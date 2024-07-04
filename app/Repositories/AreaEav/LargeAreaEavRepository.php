<?php

namespace App\Repositories\AreaEav;

use App\Models\AreaAreaEav;
use App\Repositories\AbstractBaseRepository;

class LargeAreaEavRepository extends AbstractBaseRepository implements LargeAreaEavInterface
{
    public function __construct(AreaAreaEav $model)
    {
        parent::__construct($model);
    }

}
