<?php


namespace App\Bundle\RentalSpaceBundle\Application;


class RentalSpaceGetDetailFloorPlanCommand
{
    public int $rentalSpaceId;

    public function __construct(
        int $rentalSpaceId
    )
    {
        $this->rentalSpaceId = $rentalSpaceId;
    }
}
