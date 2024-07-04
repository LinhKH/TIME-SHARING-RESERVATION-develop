<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpaceGetDetailRentalSpaceIntervalResult
{
    public int $rentalPlanId;
    public string $rentalPlanName;
    public ?array $rentalSpaceRentalIntervalResult;
    public ?array $planGroup;

    /**
     * @param int $rentalPlanId
     * @param string $rentalPlanName
     * @param array|null $planGroup
     * @param array|null $rentalSpaceRentalIntervalResult
     */
    public function __construct(
        int $rentalPlanId,
        string $rentalPlanName,
        ?array $planGroup,
        ?array $rentalSpaceRentalIntervalResult
    )
    {
        $this->planGroup = $planGroup;
        $this->rentalSpaceRentalIntervalResult = $rentalSpaceRentalIntervalResult;
        $this->rentalPlanName = $rentalPlanName;
        $this->rentalPlanId = $rentalPlanId;
    }
}
