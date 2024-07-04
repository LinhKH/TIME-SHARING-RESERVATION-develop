<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

use DateTime;

final class RentalIntervalOverrideInThisDay
{
    private DateTime $date;
    private array $intervals;

    /**
     * @param DateTime $date
     * @param RentalIntervalSlotOverride[] $intervals
     */
    public function __construct(
        DateTime $date,
        array $intervals
    ){
        $this->intervals = $intervals;
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
     * @return RentalIntervalSlotOverride[]
     */
    public function getIntervals(): array
    {
        return $this->intervals;
    }
}
