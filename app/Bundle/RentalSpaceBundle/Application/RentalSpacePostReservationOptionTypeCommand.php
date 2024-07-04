<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpacePostReservationOptionTypeCommand
{
    public int $rentalSpaceId;
    public ?array $reservationOptionTypes;

    /**
     * @param int $rentalSpaceId
     * @param RentalSpaceReservationOptionTypeObjectCommand[]|null $reservationOptionTypes
     */
    public function __construct(
        int $rentalSpaceId,
        ?array $reservationOptionTypes
    ){
        $this->reservationOptionTypes = $reservationOptionTypes;
        $this->rentalSpaceId = $rentalSpaceId;
    }
}
