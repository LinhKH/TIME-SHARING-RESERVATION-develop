<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpaceGetDetailPageCommand
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
