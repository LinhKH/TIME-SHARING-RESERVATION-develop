<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalIntervalOverrideOfPlanInThisDayGetResult
{
    public array $intervals;

    /**
     * @param RentalSpaceRentalIntervalInThisDayResult[] $intervals
     */
    public function __construct(
        array $intervals
    ){
        $this->intervals = $intervals;
    }
}
