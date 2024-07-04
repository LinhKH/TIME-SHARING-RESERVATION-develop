<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpaceRentalIntervalDetailByPlanIdGetCommand
{
    /**
     * @var int
     */
    public int $rentalPlanId;
    public int $rentalSpaceId;

    /**
     * @param int $rentalSpaceId
     * @param int $rentalPlanId
     */
    public function __construct(
        int $rentalSpaceId,
        int $rentalPlanId
    ){
        $this->rentalSpaceId = $rentalSpaceId;
        $this->rentalPlanId = $rentalPlanId;
    }
}
