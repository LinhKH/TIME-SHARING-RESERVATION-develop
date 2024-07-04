<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpaceIntervalDeleteCommand
{
    public int $rentalPlanId;
    public int $rentalIntervalId;
    public int $rentalSpaceId;

    /**
     * @param int $rentalSpaceId
     * @param int $rentalPlanId
     * @param int $rentalIntervalId
     */
    public function __construct(
        int $rentalSpaceId,
        int $rentalPlanId,
        int $rentalIntervalId
    ){
        $this->rentalSpaceId = $rentalSpaceId;
        $this->rentalIntervalId = $rentalIntervalId;
        $this->rentalPlanId = $rentalPlanId;
    }
}
