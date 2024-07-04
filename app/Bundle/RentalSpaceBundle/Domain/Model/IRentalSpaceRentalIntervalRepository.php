<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

interface IRentalSpaceRentalIntervalRepository
{
    /**
     * @param RentalSpace $rentalSpace
     * @return array{RentalSpaceId, RentalSpaceDraftStep, RentalPlanId}|null
     */
    public function createRentalSpaceRentalInterval(RentalSpace $rentalSpace): ?array;

    /**
     * @param RentalSpace $rentalSpace
     * @return RentalSpaceRentalIntervalCollection
     */
    public function findCollectionRentalInterval(RentalSpace $rentalSpace): RentalSpaceRentalIntervalCollection;

    /**
     * Find interval of Plan in Space
     *
     * @param RentalSpaceId $rentalSpaceId
     * @return array|null
     */
    public function findBySpaceId(RentalSpaceId $rentalSpaceId): ?array;

    /**
     * Find interval of Plan by Plan Id
     *
     * @param RentalPlanId $rentalPlanId
     * @return RentalIntervalInformation[]|null
     */
    public function findAllIntervalByPlanId(RentalPlanId $rentalPlanId): ?array;

    /**
     * Find interval of Plan In this day
     *
     * @param RentalPlanId $rentalPlanId
     * @param int $month
     * @param int $year
     * @return RentalSpaceRentalIntervalInThisDay[]
     */
    public function findAllIntervalOfPlanInThisDay(RentalPlanId $rentalPlanId, int $month, int $year): array;

    /**
     * Find interval by Id
     *
     * @param RentalIntervalId $rentalIntervalId
     * @return RentalIntervalInformation|null
     */
    public function findIntervalById(RentalIntervalId $rentalIntervalId): ?RentalIntervalInformation;

    /**
     * Update interval
     * @param RentalSpace $rentalSpace
     * @return RentalIntervalId[]
     */
    public function updateRentalInterval(RentalSpace $rentalSpace): array;

    /**
     * Create or Update interval slot override
     * @param RentalPlanRentalSlotsIntervalOverride $rentalIntervalSlotsInterval
     * @return RentalPlanId
     */
    public function createOrUpdateRentalIntervalSlotsOverride(RentalPlanRentalSlotsIntervalOverride $rentalIntervalSlotsInterval): RentalPlanId;

    /**
     * Find interval override of Plan In this day
     *
     * @param RentalPlanId $rentalPlanId
     * @param int $month
     * @param int $year
     * @return RentalIntervalOverrideInThisDay[]
     */
    public function findAllOverrideIntervalOfPlanInThisDay(RentalPlanId $rentalPlanId, int $month, int $year): array;

    /**
     * Find slot cache entry
     *
     * @param RentalPlanId $rentalPlanId
     * @param int $month
     * @param int $year
     * @return RentalIntervalSlotCacheEntryInThisDay[]
     */
    public function findAllSlotCacheEntryOfPlanInThisDay(RentalPlanId $rentalPlanId, int $month, int $year): array;

    /**
     * Find slot unavailable cache entry
     *
     * @param RentalSpaceId $rentalPlanId
     * @param int $month
     * @param int $year
     * @return RentalIntervalSlotCacheEntryInThisDay[]
     */
    public function findAllSlotUnavailableCacheEntryOfPlanInThisDay(RentalSpaceId $rentalPlanId, int $month, int $year): array;

    /**
     * Delete interval override
     *
     * @param RentalIntervalId $rentalIntervalId
     * @param RentalIntervalOverrideId $rentalIntervalOverrideId
     * @return bool
     */
    public function deleteOverrideIntervalById(RentalIntervalId $rentalIntervalId, RentalIntervalOverrideId $rentalIntervalOverrideId): bool;

    /**
     * @param RentalSpaceId $rentalPlanId
     * @param RentalPlanId $rentalPlanId
     * @param RentalIntervalId $rentalIntervalId
     * @return bool
     */
    public function deleteIntervalById(RentalSpaceId $rentalSpaceId, RentalPlanId $rentalPlanId, RentalIntervalId $rentalIntervalId): bool;

}
