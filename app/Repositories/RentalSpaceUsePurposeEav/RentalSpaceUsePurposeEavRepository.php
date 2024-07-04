<?php


namespace App\Repositories\RentalSpaceUsePurposeEav;

use App\Models\RentalSpaceUsePurposeEav;
use App\Repositories\AbstractBaseRepository;

class RentalSpaceUsePurposeEavRepository extends AbstractBaseRepository implements RentalSpaceUsePurposeEavInterface
{
    public function __construct(RentalSpaceUsePurposeEav $model)
    {
        parent::__construct($model);
    }

}

