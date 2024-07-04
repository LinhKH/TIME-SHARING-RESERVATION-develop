<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpacePostRentalPlanResult
{
    public int $rentalSpaceId;
    public int $rentalPlanId;
    public string $draftStep;

    /**
     * @param int $rentalSpaceId rentalSpaceId
     * @param string $draftStep draftStep
     */
    public function __construct(
        int $rentalSpaceId,
        int $rentalPlanId,
        string $draftStep
    ) {
        $this->rentalSpaceId = $rentalSpaceId;
        $this->rentalPlanId = $rentalPlanId;
        $this->draftStep = $draftStep;
    }
}
