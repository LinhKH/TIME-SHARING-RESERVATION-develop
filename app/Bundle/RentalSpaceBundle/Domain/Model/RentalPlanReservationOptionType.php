<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

final class RentalPlanReservationOptionType
{
    private ReservationOptionTypeId $reservationOptionId;
    private int $orderNumber;

    public function __construct(
        ReservationOptionTypeId $reservationOptionId,
        int $orderNumber
    ){
        $this->orderNumber = $orderNumber;
        $this->reservationOptionId = $reservationOptionId;
    }

    /**
     * @return ReservationOptionTypeId
     */
    public function getReservationOptionId(): ReservationOptionTypeId
    {
        return $this->reservationOptionId;
    }

    /**
     * @return int
     */
    public function getOrderNumber(): int
    {
        return $this->orderNumber;
    }
}
