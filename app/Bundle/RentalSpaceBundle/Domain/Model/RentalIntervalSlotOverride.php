<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

use DateTime;

final class RentalIntervalSlotOverride
{
    private RentalIntervalId $rentalIntervalId;
    private DateTime $dayIndent;
    private DateTime $intervalStartTime;
    private DateTime $intervalEndTime;
    private ?int $tenancyPrice;
    private ?RentalIntervalOverrideId $rentalIntervalOverrideId;

    /**
     * @param RentalIntervalOverrideId|null $rentalIntervalOverrideId
     * @param RentalIntervalId $rentalIntervalId
     * @param DateTime $dayIndent
     * @param DateTime $intervalStartTime
     * @param DateTime $intervalEndTime
     * @param int|null $tenancyPrice
     */
    public function __construct(
        ?RentalIntervalOverrideId $rentalIntervalOverrideId,
        RentalIntervalId $rentalIntervalId,
        DateTime $dayIndent,
        DateTime $intervalStartTime,
        DateTime $intervalEndTime,
        ?int $tenancyPrice

    ){
        $this->rentalIntervalOverrideId = $rentalIntervalOverrideId;
        $this->tenancyPrice = $tenancyPrice;
        $this->intervalEndTime = $intervalEndTime;
        $this->intervalStartTime = $intervalStartTime;
        $this->dayIndent = $dayIndent;
        $this->rentalIntervalId = $rentalIntervalId;
    }

    /**
     * @return RentalIntervalOverrideId|null
     */
    public function getRentalIntervalOverrideId(): ?RentalIntervalOverrideId
    {
        return $this->rentalIntervalOverrideId;
    }

    /**
     * @return int|null
     */
    public function getTenancyPrice(): ?int
    {
        return $this->tenancyPrice;
    }

    /**
     * @return RentalIntervalId
     */
    public function getRentalIntervalId(): RentalIntervalId
    {
        return $this->rentalIntervalId;
    }

    /**
     * @return DateTime
     */
    public function getDayIndent(): DateTime
    {
        return $this->dayIndent;
    }

    /**
     * @return DateTime
     */
    public function getIntervalStartTime(): DateTime
    {
        return $this->intervalStartTime;
    }

    /**
     * @return DateTime
     */
    public function getIntervalEndTime(): DateTime
    {
        return $this->intervalEndTime;
    }
}
