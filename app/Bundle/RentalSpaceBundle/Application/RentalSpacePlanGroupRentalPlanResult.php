<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpacePlanGroupRentalPlanResult
{
    public int $planId;
    public string $planName;

    /**
     * @param int $planId
     * @param string $planName
     */
    public function __construct(
        int $planId,
        string $planName
    ){
        $this->planName = $planName;
        $this->planId = $planId;
    }
}
