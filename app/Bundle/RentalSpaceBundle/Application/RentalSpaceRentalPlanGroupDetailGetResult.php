<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpaceRentalPlanGroupDetailGetResult
{
    public RentalSpacePlanGroupResult $planGroupResult;

    /**
     * @param RentalSpacePlanGroupResult $planGroupResult
     */
    public function __construct(
        RentalSpacePlanGroupResult $planGroupResult
    ){
        $this->planGroupResult = $planGroupResult;
    }
}
