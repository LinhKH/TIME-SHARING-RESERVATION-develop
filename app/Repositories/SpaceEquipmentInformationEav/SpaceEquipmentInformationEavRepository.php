<?php

namespace App\Repositories\SpaceEquipmentInformationEav;

use App\Models\RentalSpaceEquipmentInformationEav;
use App\Repositories\AbstractBaseRepository;

class SpaceEquipmentInformationEavRepository extends AbstractBaseRepository implements SpaceEquipmentInformationEavInterface
{
    public function __construct(RentalSpaceEquipmentInformationEav $model)
    {
        parent::__construct($model);
    }
}
