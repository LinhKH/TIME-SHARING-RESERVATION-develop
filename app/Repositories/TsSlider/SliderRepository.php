<?php

namespace App\Repositories\TsSlider;

use App\Models\TsSlider;
use App\Repositories\AbstractBaseRepository;

class SliderRepository extends AbstractBaseRepository implements SliderInterface
{
    public function __construct(TsSlider $model)
    {
        parent::__construct($model);
    }

}
