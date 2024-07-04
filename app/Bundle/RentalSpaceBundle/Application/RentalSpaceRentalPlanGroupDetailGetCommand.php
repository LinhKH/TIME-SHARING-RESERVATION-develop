<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpaceRentalPlanGroupDetailGetCommand
{
    /**
     * @var int
     */
    public int $rentalPlanGroupId;

    /**
     * @param int $rentalPlanGroupId
     */
    public function __construct(
        int $rentalPlanGroupId
    ){
        $this->rentalPlanGroupId = $rentalPlanGroupId;
    }
}
