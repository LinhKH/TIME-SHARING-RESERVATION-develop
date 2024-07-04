<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class NearTransportationDeleteCommand
{
    public int $nearTransportationId;
    public int $rentalSpaceId;

    /**
     * @param int $rentalSpaceId
     * @param int $nearTransportationId
     */
    public function __construct(
        int $rentalSpaceId,
        int $nearTransportationId
    ){
        $this->rentalSpaceId = $rentalSpaceId;
        $this->nearTransportationId = $nearTransportationId;
    }
}
