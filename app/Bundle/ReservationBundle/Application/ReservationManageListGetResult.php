<?php

namespace App\Bundle\ReservationBundle\Application;

use App\Bundle\Common\Domain\Model\PaginationResult;

final class ReservationManageListGetResult
{
    public PaginationResult $pagination;
    public array $reservationManages;

    /**
     * @param PaginationResult $pagination
     * @param ReservationManageResult[] $reservationManages
     */
    public function __construct(
        PaginationResult $pagination,
        array $reservationManages

    ) {
        $this->pagination = $pagination;
        $this->reservationManages = $reservationManages;
    }
}
