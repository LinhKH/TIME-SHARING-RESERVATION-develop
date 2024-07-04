<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalIntervalDetailByIdGetCommand
{
    /**
     * @var int
     */
    public int $rentalIntervalId;

    /**
     * @param int $rentalIntervalId
     */
    public function __construct(
        int $rentalIntervalId
    ){
        $this->rentalIntervalId = $rentalIntervalId;
    }
}
