<?php


namespace App\Bundle\RentalSpaceBundle\Application;


class RentalSpaceGetDetailDirectionStationImageCommand
{
    public int $rentalSpaceId;

    public function __construct(
        int $rentalSpaceId
    )
    {
        $this->rentalSpaceId = $rentalSpaceId;
    }
}
