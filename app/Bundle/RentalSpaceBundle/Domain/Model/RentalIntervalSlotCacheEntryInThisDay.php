<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

use DateTime;

final class RentalIntervalSlotCacheEntryInThisDay
{
    private DateTime $date;
    private array $slotCacheEntry;

    /**
     * @param DateTime $date
     * @param RentalIntervalSlotCacheEntry[] $slotCacheEntry
     */
    public function __construct(
        DateTime $date,
        array $slotCacheEntry
    ){
        $this->slotCacheEntry = $slotCacheEntry;
        $this->date = $date;
    }

    /**
     * @return DateTime
     */
    public function getDate(): DateTime
    {
        return $this->date;
    }

    /**
     * @return RentalIntervalSlotCacheEntry[]
     */
    public function getIntervals(): array
    {
        return $this->slotCacheEntry;
    }
}
