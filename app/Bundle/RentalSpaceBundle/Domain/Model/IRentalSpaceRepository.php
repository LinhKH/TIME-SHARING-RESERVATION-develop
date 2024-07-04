<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

use App\Bundle\OrganizationBundle\Domain\Model\OrganizationId;

interface IRentalSpaceRepository
{
    /**
     * Find all information of rental space by ID
     * @param RentalSpaceId $rentalSpaceId
     * @return RentalSpaceAllInformation|null
     */
    public function findById(RentalSpaceId $rentalSpaceId): ?RentalSpaceAllInformation;

    /**
     * @param OrganizationId $organizationId
     * @return RentalSpaceCollection[]|null
     */
    public function getListIdByOrganizationId(OrganizationId $organizationId): ?array;

    /**
     * @param RentalSpaceId[] $rentalSpaceUpdate
     * @param RentalSpaceId[] $rentalSpaceInOrganization
     * @return bool
     */
    public function updateTourSetting(array $rentalSpaceUpdate, array $rentalSpaceInOrganization): bool;
}
