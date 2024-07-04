<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpaceRentalSlotIntervalCacheEntryInThisDayGetResult
{
    public array $slotsCacheEntry;

    /**
     * @param RentalSpaceRentalSlotIntervalCacheEntryInThisDayResult[] $slotsCacheEntry
     */
    public function __construct(
        array $slotsCacheEntry
    ){
        $this->slotsCacheEntry = $slotsCacheEntry;
    }
}
