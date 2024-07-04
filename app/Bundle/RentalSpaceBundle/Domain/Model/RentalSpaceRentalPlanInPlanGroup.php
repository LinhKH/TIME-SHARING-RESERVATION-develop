<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

final class RentalSpaceRentalPlanInPlanGroup
{
    private RentalPlanId $planId;
    private RentalPlanStatusType $status;

    /**
     * @param RentalPlanId $planId
     * @param RentalPlanStatusType $status
     */
    public function __construct(
        RentalPlanId $planId,
        RentalPlanStatusType $status
    ){
        $this->status = $status;
        $this->planId = $planId;
    }

    /**
     * @return RentalPlanId
     */
    public function getPlanId(): RentalPlanId
    {
        return $this->planId;
    }

    /**
     * @return RentalPlanStatusType
     */
    public function getStatus(): RentalPlanStatusType
    {
        return $this->status;
    }


}
