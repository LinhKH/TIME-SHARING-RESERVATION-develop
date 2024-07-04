<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpaceGetDetailRentalPlanCommand
{
    /**
     * @var int
     */
    public int $rentalSpaceId;
    public int $rentalPlanId;

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
