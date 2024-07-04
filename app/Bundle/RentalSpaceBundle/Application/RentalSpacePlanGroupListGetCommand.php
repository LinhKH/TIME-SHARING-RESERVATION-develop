<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpacePlanGroupListGetCommand
{
    public int $rentalSpaceId;

    /**
     * @param int $rentalSpaceId
     */
    public function __construct(
        int $rentalSpaceId
    )
    {
        $this->rentalSpaceId = $rentalSpaceId;
    }
}
