<?php

namespace App\Bundle\ReservationBundle\Domain\Model;

interface IReservationRepository
{
    /**
     * @param Reservation $reservation
     * @return ReservationId
     */
    public function createReservationPlanLess(Reservation $reservation): ReservationId;

    /**
     * @return array{ReservationManageCollection, Pagination}
     */
    public function findAll(ReservationCriteria $pagePaginationCriteria): array;
}
