<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpaceRentalSlotIntervalCacheEntryInThisDayResult
{
    public string $date;
    public array $slotsCacheEntry;

    /**
     * @param string $date
     * @param RentalSpaceRentalSlotIntervalCacheEntryResult[] $slotsCacheEntry
     */
    public function __construct(
        string $date,
        array $slotsCacheEntry
    ){
        $this->slotsCacheEntry = $slotsCacheEntry;
        $this->date = $date;
    }
}
