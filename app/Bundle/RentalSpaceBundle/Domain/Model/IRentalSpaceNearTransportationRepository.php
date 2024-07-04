<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

use App\Bundle\TransportationBundle\Domain\TransportationId;

interface IRentalSpaceNearTransportationRepository
{
    /**
     * Update Or create Near Transportation
     * @param NearTransportationInformation[] $nearTransportation
     * @return RentalSpaceId|null
     */
    public function createOrUpdateNearTransportation(array $nearTransportation): ?RentalSpaceId;

    /**
     * @param RentalSpaceId $rentalSpaceId
     * @return NearTransportationInformation[]
     */
    public function findAllTransportationBySpaceId(RentalSpaceId $rentalSpaceId): array;

    /**
     * @param RentalSpaceId $rentalSpaceId
     * @param TransportationId $nearTransportationId
     * @return RentalSpaceId
     */
    public function deleteNearTransportation(RentalSpaceId $rentalSpaceId, TransportationId $nearTransportationId): RentalSpaceId;
}
