<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class NearTransportationPostResult
{
    public ?int $rentalSpaceId;

    /**
     * @param int|null $rentalSpaceId
     */
    public function __construct(
        ?int $rentalSpaceId
    ){
        $this->rentalSpaceId = $rentalSpaceId;
    }
}
