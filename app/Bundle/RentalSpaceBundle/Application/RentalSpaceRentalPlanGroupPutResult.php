<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpaceRentalPlanGroupPutResult
{
    public int $rentalSpacePlanGroupId;

    /**
     * @param int $rentalSpacePlanGroupId
     */
    public function __construct(
        int $rentalSpacePlanGroupId
    ){
        $this->rentalSpacePlanGroupId = $rentalSpacePlanGroupId;
    }
}
