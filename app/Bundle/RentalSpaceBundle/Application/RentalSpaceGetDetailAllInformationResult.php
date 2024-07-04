<?php

namespace App\Bundle\RentalSpaceBundle\Application;

use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;

final class RentalSpaceGetDetailAllInformationResult
{
    public RentalSpaceGetAllInformationResult $rentalSpaceInformation;
    public RentalSpaceId $rentalSpaceId;

    /**
     * @param RentalSpaceId $rentalSpaceId
     * @param RentalSpaceGetAllInformationResult $rentalSpaceInformation
     */
    public function __construct(
        RentalSpaceId $rentalSpaceId,
        RentalSpaceGetAllInformationResult $rentalSpaceInformation
    )
    {
        $this->rentalSpaceId = $rentalSpaceId;
        $this->rentalSpaceInformation = $rentalSpaceInformation;
    }
}
