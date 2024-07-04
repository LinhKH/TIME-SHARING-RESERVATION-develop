<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpaceGetDetailTrackLinkCommand
{
    /**
     * @var int
     */
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
