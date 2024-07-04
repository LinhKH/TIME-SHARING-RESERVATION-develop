<?php

namespace App\Bundle\ReservationBundle\Domain\Model;

final class ReservationManageCollection
{
    private array $reservationManages;

    /**
     * @param ReservationManage[] $reservationManages
     */
    public function __construct(
        array $reservationManages
    ){
        $this->reservationManages = $reservationManages;
    }

    /**
     * @return array
     */
    public function getReservationManages(): array
    {
        return $this->reservationManages;
    }

}
