<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpacePlanGroupListGetResult
{
    public ?array $rentalPlanGroups;

    /**
     * @param RentalSpacePlanGroupResult[]|null $rentalPlanGroups
     */
    public function __construct(
        ?array $rentalPlanGroups
    ){
        $this->rentalPlanGroups = $rentalPlanGroups;
    }
}
