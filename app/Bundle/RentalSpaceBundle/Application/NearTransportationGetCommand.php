<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class NearTransportationGetCommand
{
    public int $rentalSpaceId;

    /**
     * @param int $rentalSpaceId
     */
    public function __construct(
        int $rentalSpaceId
    ){
        $this->rentalSpaceId = $rentalSpaceId;
    }
}
