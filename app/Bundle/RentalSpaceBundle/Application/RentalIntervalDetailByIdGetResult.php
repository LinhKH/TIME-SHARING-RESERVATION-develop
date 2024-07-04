<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalIntervalDetailByIdGetResult
{
    public ?RentalSpaceRentalIntervalResult $intervals;

    /**
     * @param RentalSpaceRentalIntervalResult|null $intervals
     */
    public function __construct(
        ?RentalSpaceRentalIntervalResult $intervals
    ){
        $this->intervals = $intervals;
    }
}
