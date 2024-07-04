<?php

namespace App\Bundle\RentalSpaceBundle\Application;

class RentalSpacePlanGetListByRentalSpaceIdResult
{

    public array $rentalPlan;

    /**
     * @param array $rentalPlan
     */
    public function __construct(
        array $rentalPlan
    ){
        $this->rentalPlan = $rentalPlan;
    }
}
