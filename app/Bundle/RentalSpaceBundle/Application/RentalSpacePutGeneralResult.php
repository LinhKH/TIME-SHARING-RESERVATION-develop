<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpacePutGeneralResult
{
    public int $rentalSpaceId;

    /**
     * @param int $rentalSpaceId rentalSpaceId
     */
    public function __construct(
        int $rentalSpaceId
    ) {
        $this->rentalSpaceId = $rentalSpaceId;
    }
}
