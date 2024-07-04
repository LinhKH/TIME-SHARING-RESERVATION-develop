<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalIntervalSlotOverrideUpdatePutResult
{
    public ?int $rentalPlanId;

    /**
     * @param int|null $rentalPlanId
     */
    public function __construct(
        ?int $rentalPlanId
    )
    {
        $this->rentalPlanId = $rentalPlanId;
    }
}
