<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpacePostReservationOptionTypeResult
{
    public int $rentalSpaceId;
    public string $draftStep;

    /**
     * @param int $rentalSpaceId rentalSpaceId
     * @param string $draftStep draftStep
     */
    public function __construct(
        int $rentalSpaceId,
        string $draftStep
    ) {
        $this->rentalSpaceId = $rentalSpaceId;
        $this->draftStep = $draftStep;
    }
}
