<?php

namespace App\Repositories\SpaceEquipmentInformation;

use App\Models\RentalSpaceEquipmentInformation;
use App\Repositories\AbstractBaseRepository;

class SpaceEquipmentInformationRepository extends AbstractBaseRepository implements SpaceEquipmentInformationInterface
{
    public function __construct(RentalSpaceEquipmentInformation $model)
    {
        parent::__construct($model);
    }

}
