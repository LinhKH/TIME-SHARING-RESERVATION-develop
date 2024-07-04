<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpaceRentalIntervalInThisDayResult
{
    public string $date;
    public array $intervals;

    /**
     * @param string $date
     * @param RentalIntervalOverrideResult[] $intervals
     */
    public function __construct(
        string $date,
        array $intervals
    ){
        $this->intervals = $intervals;
        $this->date = $date;
    }
}
