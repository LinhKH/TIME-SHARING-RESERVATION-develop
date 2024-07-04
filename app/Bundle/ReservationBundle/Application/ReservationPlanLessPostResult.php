<?php

namespace App\Bundle\ReservationBundle\Application;

final class ReservationPlanLessPostResult
{
    public int $reservationId;

    /**
     * @param int $reservationId
     */
    public function __construct(
        int $reservationId
    ){
        $this->reservationId = $reservationId;
    }
}
