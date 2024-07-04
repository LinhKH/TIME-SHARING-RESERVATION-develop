<?php


namespace App\Repositories\RentalSpaceUsePurposeImage;

use App\Models\RentalSpaceUsePurposeImage;
use App\Repositories\AbstractBaseRepository;

class RentalSpaceUsePurposeImageRepository extends AbstractBaseRepository implements RentalSpaceUsePurposeImageInterface
{
    public function __construct(RentalSpaceUsePurposeImage $model)
    {
        parent::__construct($model);
    }

}

