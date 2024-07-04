<?php

namespace App\Repositories\TsSliderItem;

use App\Models\TsSliderItem;
use App\Repositories\AbstractBaseRepository;

class SliderItemRepository extends AbstractBaseRepository implements SliderItemInterface
{
    public function __construct(TsSliderItem $model)
    {
        parent::__construct($model);
    }

}
