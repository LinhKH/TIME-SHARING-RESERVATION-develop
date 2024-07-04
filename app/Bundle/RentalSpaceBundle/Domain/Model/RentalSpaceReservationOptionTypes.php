<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

use App\Bundle\RentalSpaceBundle\Application\RentalSpaceReservationOptionTypeObjectCommand;

final class RentalSpaceReservationOptionTypes
{
    private RentalSpaceId $rentalSpaceId;
    private ?array $reservationOptionTypes;

    /**
     * @param RentalSpaceId $rentalSpaceId
     * @param RentalSpaceReservationOptionTypeObjectCommand[]|null $reservationOptionTypes
     */
    public function __construct(
        RentalSpaceId $rentalSpaceId,
        ?array $reservationOptionTypes
    ){
        $this->reservationOptionTypes = $reservationOptionTypes;
        $this->rentalSpaceId = $rentalSpaceId;
    }

    /**
     * @return RentalSpaceId
     */
    public function getRentalSpaceId(): RentalSpaceId
    {
        return $this->rentalSpaceId;
    }

    /**
     * @return RentalSpaceReservationOptionTypeObjectCommand[]
     */
    public function getReservationOptionTypes(): ?array
    {
        return $this->reservationOptionTypes;
    }
}
