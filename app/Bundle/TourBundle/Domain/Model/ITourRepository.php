<?php

namespace App\Bundle\TourBundle\Domain\Model;

use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;

interface ITourRepository
{
    /**
     * @param Tour $tour
     * @return TourId
     */
    public function createTour(Tour $tour): TourId;

    /**
     * no param
     * @return array{\App\Bundle\TourBundle\Model\Tour[], \App\Bundle\UserBundle\Domain\Model\Pagination}
     */
    public function findAll(): array;

    /**
     * @param TourApproval $tourApproval
     * @return TourId
     */
    public function updateTourApproval(TourApproval $tourApproval): TourId;

    /**
     * @param TourNonApproval $tourNonApproval
     * @return TourId
     */
    public function updateTourNonApproval(TourNonApproval $tourNonApproval): TourId;

    /**
     * @param TourId $tourId
     * @return Tour|null
     */
    public function findById(TourId $tourId): ?Tour;
}
