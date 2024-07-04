<?php

namespace App\Repositories\TsNews;

use App\Models\TsNews;
use App\Repositories\AbstractBaseRepository;

class NewsRepository extends AbstractBaseRepository implements NewsInterface
{
    public function __construct(TsNews $model)
    {
        parent::__construct($model);
    }

}
