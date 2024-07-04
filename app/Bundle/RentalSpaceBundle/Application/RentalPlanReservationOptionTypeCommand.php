<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalPlanReservationOptionTypeCommand
{
    public int $reservationOptionId;
    public int $orderNumber;

    public function __construct(
        int $reservationOptionId,
        int $orderNumber
    ){
        $this->orderNumber = $orderNumber;
        $this->reservationOptionId = $reservationOptionId;
    }
}
