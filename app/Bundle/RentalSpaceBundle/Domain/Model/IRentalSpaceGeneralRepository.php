<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

interface IRentalSpaceGeneralRepository
{
    /**
     * @param PagePaginationCriteria $rentalSpacePaginationCriteria rentalSpaceCommandPage
     * @return array{RentalSpaceCollection[], Pagination}
     */
    public function findAll(PagePaginationCriteria $rentalSpacePaginationCriteria, $fillter): array;

    /**
     * Create rental space general
     * @param RentalSpace $rentalSpace
     * @return array{RentalSpaceId, RentalSpaceDraftStep}
     */
    public function createRentalSpaceGeneral(RentalSpace $rentalSpace): array;

    /**
     * Find rental space by ID
     * @param RentalSpaceId $rentalSpaceId
     * @return RentalSpaceGeneral|null
     */
    public function findById(RentalSpaceId $rentalSpaceId): ?RentalSpaceGeneral;

    /**
     * Find rental space by ID
     * @param RentalSpaceId $rentalSpaceId
     * @return RentalSpace|null
     */
    public function findCurrentDraftStepBySpaceId(RentalSpaceId $rentalSpaceId): ?RentalSpace;

    /**
     * Find rental space by ID
     * @param RentalSpaceId $rentalSpaceId
     * @return bool
     */
    public function checkExistSpace(RentalSpaceId $rentalSpaceId): bool;

    /**
     * Update rental space general
     * @param RentalSpace $rentalSpace
     * @return RentalSpaceId
     */
    public function updateRentalSpaceGeneral(RentalSpace $rentalSpace): RentalSpaceId;
}
