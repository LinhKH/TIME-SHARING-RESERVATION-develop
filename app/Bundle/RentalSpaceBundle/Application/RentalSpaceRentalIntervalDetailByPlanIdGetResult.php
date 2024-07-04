<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpaceRentalIntervalDetailByPlanIdGetResult
{
    public ?array $intervals;

    /**
     * @param RentalSpaceRentalIntervalResult[]|null $intervals
     */
    public function __construct(
        ?array $intervals
    ){
        $this->intervals = $intervals;
    }
}
