<?php


namespace App\Bundle\RentalSpaceBundle\Application;


final class RentalSpaceGetDetailFacadeImageCommand
{
    public int $rentalSpaceId;

    public function __construct(
        int $rentalSpaceId
    )
    {
        $this->rentalSpaceId = $rentalSpaceId;
    }
}
