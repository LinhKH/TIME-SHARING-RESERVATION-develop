<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpaceRentalPlanGroupPostResult
{
    public int $rentalSpaceId;
    public int $rentalSpacePlanGroupId;

    /**
     * @param int $rentalSpaceId
     * @param int $rentalSpacePlanGroupId
     */
    public function __construct(
        int $rentalSpaceId,
        int $rentalSpacePlanGroupId
    ){
        $this->rentalSpaceId = $rentalSpaceId;
        $this->rentalSpacePlanGroupId = $rentalSpacePlanGroupId;
    }
}
