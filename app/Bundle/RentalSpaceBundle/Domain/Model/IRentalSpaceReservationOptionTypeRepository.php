<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

interface IRentalSpaceReservationOptionTypeRepository
{
    /**
     * @param RentalSpace $rentalSpace
     * @return array{RentalSpaceId, RentalSpaceDraftStep}
     */
    public function createRentalSpaceReservationOptionType(RentalSpace $rentalSpace): array;

    /**
     * Find Option Type by Space ID
     * @param RentalSpaceId $rentalSpaceId
     * @return array|null
     */
    public function findById(RentalSpaceId $rentalSpaceId): ?array;
}
