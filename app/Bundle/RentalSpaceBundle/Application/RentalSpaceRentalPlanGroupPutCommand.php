<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpaceRentalPlanGroupPutCommand
{
    public int $rentalPlanGroupId;
    public string $planGroupName;
    public ?array $plans;
    public string $planGroupStatus;

    /**
     * @param int $rentalPlanGroupId
     * @param string $planGroupName
     * @param string $planGroupStatus
     * @param RentalSpaceRentalPlanInPlanGroup[] $plans
     */
    public function __construct(
        int $rentalPlanGroupId,
        string $planGroupName,
        string $planGroupStatus,
        ?array $plans
    ){
        $this->planGroupStatus = $planGroupStatus;
        $this->plans = $plans;
        $this->planGroupName = $planGroupName;
        $this->rentalPlanGroupId = $rentalPlanGroupId;
    }
}
