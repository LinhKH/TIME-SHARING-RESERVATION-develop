<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpaceRentalPlanInPlanGroup
{
    public int $planId;
    public string $status;

    /**
     * @param int $planId
     * @param string $status
     */
    public function __construct(
        int $planId,
        string $status
    ){
        $this->status = $status;
        $this->planId = $planId;
    }
}
