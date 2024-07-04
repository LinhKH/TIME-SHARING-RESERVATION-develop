<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpaceRentalIntervalPutResult
{
    public array $rentalIntervalIds;

    /**
     * @param int[] $rentalIntervalIds
     */
    public function __construct(
        array $rentalIntervalIds
    ) {
        $this->rentalIntervalIds = $rentalIntervalIds;
    }
}
