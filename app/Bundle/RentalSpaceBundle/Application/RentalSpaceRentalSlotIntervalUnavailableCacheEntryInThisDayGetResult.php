<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpaceRentalSlotIntervalUnavailableCacheEntryInThisDayGetResult
{
    public array $slotsUnavailableCacheEntry;

    /**
     * @param RentalSpaceRentalSlotIntervalCacheEntryInThisDayResult[] $slotsUnavailableCacheEntry
     */
    public function __construct(
        array $slotsUnavailableCacheEntry
    ){
        $this->slotsUnavailableCacheEntry = $slotsUnavailableCacheEntry;
    }
}
