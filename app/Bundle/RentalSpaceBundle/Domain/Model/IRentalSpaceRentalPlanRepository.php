<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

use phpDocumentor\Reflection\Types\Mixed_;

interface IRentalSpaceRentalPlanRepository
{
    /**
     * @param RentalSpace $rentalSpace
     * @return array{RentalSpaceId, RentalSpaceDraftStep, RentalPlanId}
     */
    public function createRentalSpaceRentalPlan(RentalSpace $rentalSpace): array;

    /**
     * @param RentalPlanId $rentalPlanId
     * @param RentalPlanImageInformation $imageUploadInformation
     * @return mixed
     */
    public function uploadImageRentalPlan(RentalPlanId $rentalPlanId, RentalPlanImageInformation $imageUploadInformation);

    /**
     * Find All Plan by SpaceId
     *
     * @param RentalSpaceId $rentalSpaceId
     * @return array|null
     */
    public function findBySpaceId(RentalSpaceId $rentalSpaceId): ?array;

    /**
     * Get First Plan by SpaceId
     *
     * @param RentalSpaceId $rentalSpaceId
     * @return RentalPlanId|null
     */
    public function firstPlanBySpaceId(RentalSpaceId $rentalSpaceId): ?RentalPlanId;

    /**
     * Get Detail Rental Plan
     *
     * @param RentalSpaceId $rentalSpaceId
     * @param RentalPlanId $rentalPlanId
     * @return array{RentalSpaceRentalPlan, RentalPlanImageInformation}|null
     */
    public function findById(RentalSpaceId $rentalSpaceId, RentalPlanId $rentalPlanId): ?array;

    /**
     * Create Plan Group
     * @param RentalSpace $rentalSpace
     * @return array{RentalSpaceId, RentalPlanGroupId}
     */
    public function createRentalSpaceRentalPlanGroup(RentalSpace $rentalSpace): array;

    /**
     * Find All Plan Group by SpaceId
     *
     * @param RentalSpaceId $rentalSpaceId
     * @return RentalSpaceRentalPlanGroup[]|null
     */
    public function findAllPlanGroup(RentalSpaceId $rentalSpaceId): ?array;

    /**
     * Detai Plan group by id
     * @param RentalPlanGroupId $rentalPlanGroupId
     * @return RentalSpaceRentalPlanGroup|null
     */
    public function findPlanGroupById(RentalPlanGroupId $rentalPlanGroupId): ?RentalSpaceRentalPlanGroup;

    /**
     * Update Rental Plan
     *
     * @param RentalSpace $rentalSpace
     * @return RentalPlanId
     */
    public function updateRentalPlan(RentalSpace $rentalSpace): RentalPlanId;

    /**
     * Update Plan Group
     * @param RentalSpace $rentalSpace
     * @return RentalPlanGroupId
     */
    public function updateRentalPlanGroup(RentalSpace $rentalSpace): RentalPlanGroupId;
}
