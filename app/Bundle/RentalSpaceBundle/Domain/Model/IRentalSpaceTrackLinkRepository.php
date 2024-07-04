<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

use Illuminate\Http\JsonResponse;

interface IRentalSpaceTrackLinkRepository
{
    /**
     * @param RentalSpaceTrackLink $rentalSpaceTrackLink
     * @return RentalSpaceTrackLink
     */
    public function createRentalSpaceTrackLink(RentalSpaceTrackLink $rentalSpaceTrackLink): RentalSpaceTrackLink;

    /**
     * Find tracking link by Space ID
     * @param RentalSpaceId $rentalSpaceId
     * @return TrackingLinkInformation[]|null
     */
    public function findBySpaceId(RentalSpaceId $rentalSpaceId): ?array;

}
