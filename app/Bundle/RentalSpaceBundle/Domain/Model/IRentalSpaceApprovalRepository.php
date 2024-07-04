<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

interface IRentalSpaceApprovalRepository
{
    /**
     * Create rental space general
     * @param RentalSpace $rentalSpace
     * @return array{RentalSpaceId, RentalSpaceDraftStep}
     */
    public function updateRentalSpaceApproval(RentalSpace $rentalSpace): array;


    /**
     * Find rental space approval by SpaceID
     * @param RentalSpaceId $rentalSpaceId
     * @return RentalSpaceApproval|null
     */
    public function findBySpaceId(RentalSpaceId $rentalSpaceId): ?RentalSpaceApproval;
}
