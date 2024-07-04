<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

interface IRentalSpaceEquipmentInformationRepository
{
    /**
     * Create rental space Equipment Information
     * @param RentalSpace $rentalSpace
     * @return array{RentalSpaceId, RentalSpaceDraftStep}
     */
    public function createRentalSpaceEquipmentInformation(RentalSpace $rentalSpace): array;

    /**
     * Find rental space Equipment Information by SpaceID
     * @param RentalSpaceId $rentalSpaceId
     * @return RentalSpaceEquipmentInformation|null
     */
    public function findById(RentalSpaceId $rentalSpaceId): ?RentalSpaceEquipmentInformation;

    /**
     * Update rental space Equipment Information
     * @param RentalSpace $rentalSpace
     * @return RentalSpaceId
     */
    public function updateRentalSpaceEquipmentInformation(RentalSpace $rentalSpace): RentalSpaceId;
}
