<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpaceRentalPlanPutResult
{
    public int $rentalPlanId;

    /**
     * @param int $rentalPlanId
     */
    public function __construct(
        int $rentalPlanId
    ) {
        $this->rentalPlanId = $rentalPlanId;
    }
}
