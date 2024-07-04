<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpacePlanGroupResult
{
    public int $planGroupId;
    public string $planGroupName;
    public ?array $rentalPlans;
    public ?string $status;

    /**
     * @param int $planGroupId
     * @param string $planGroupName
     * @param string|null $status
     * @param RentalSpacePlanGroupRentalPlanResult[]|null $rentalPlans
     */
    public function __construct(
        int $planGroupId,
        string $planGroupName,
        ?string $status,
        ?array $rentalPlans
    ){
        $this->status = $status;
        $this->rentalPlans = $rentalPlans;
        $this->planGroupName = $planGroupName;
        $this->planGroupId = $planGroupId;
    }
}
