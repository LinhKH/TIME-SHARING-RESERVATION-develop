<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalIntervalOverrideDelete
{
    public int $rentalIntervalId;
    public string $rentalIntervalOverrideId;

    /**
     * @param int $rentalIntervalId
     * @param string $rentalIntervalOverrideId
     */
    public function __construct(
        int $rentalIntervalId,
        string $rentalIntervalOverrideId
    ){
        $this->rentalIntervalOverrideId = $rentalIntervalOverrideId;
        $this->rentalIntervalId = $rentalIntervalId;
    }
}
