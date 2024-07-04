<?php


namespace App\Bundle\RentalSpaceBundle\Application;


final class RentalSpaceGetDetailPanoramaImageCommand
{
    public int $rentalSpaceId;

    public function __construct(
        int $rentalSpaceId
    )
    {
        $this->rentalSpaceId = $rentalSpaceId;
    }
}
