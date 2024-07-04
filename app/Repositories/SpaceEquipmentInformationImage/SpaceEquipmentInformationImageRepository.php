<?php

namespace App\Repositories\SpaceEquipmentInformationImage;

use App\Models\RentalSpaceEquipmentInformationImage;
use App\Repositories\AbstractBaseRepository;

class SpaceEquipmentInformationImageRepository extends AbstractBaseRepository implements SpaceEquipmentInformationImageInterface
{
    public function __construct(RentalSpaceEquipmentInformationImage $model)
    {
        parent::__construct($model);
    }

}
