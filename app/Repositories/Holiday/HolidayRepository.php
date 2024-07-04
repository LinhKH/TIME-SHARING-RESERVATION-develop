<?php


namespace App\Repositories\Holiday;
use App\Models\Holiday;
use App\Repositories\AbstractBaseRepository;
class HolidayRepository extends AbstractBaseRepository implements HolidayInterface
{
    public function __construct(Holiday $model)
    {
        parent::__construct($model);
    }

}

