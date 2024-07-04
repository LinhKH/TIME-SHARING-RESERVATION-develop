<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpaceRentalPlanGroupPostCommand
{
    public int $rentalSpaceId;
    public string $planGroupName;
    public ?array $rentalPlanIds;

    /**
     * @param int $rentalSpaceId
     * @param string $planGroupName
     * @param int[]|null $rentalPlanIds
     */
    public function __construct(
        int $rentalSpaceId,
        string $planGroupName,
        ?array $rentalPlanIds
    ){
        $this->rentalPlanIds = $rentalPlanIds;
        $this->planGroupName = $planGroupName;
        $this->rentalSpaceId = $rentalSpaceId;
    }
}
