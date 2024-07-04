<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpaceGetDetailReservationOptionTypeResult
{
    public ?array $reservationOptionTypes;

    /**
     * @param array|null $reservationOptionTypes
     */
    public function __construct(
        ?array $reservationOptionTypes
    ){
        $this->reservationOptionTypes = $reservationOptionTypes;
    }
}
