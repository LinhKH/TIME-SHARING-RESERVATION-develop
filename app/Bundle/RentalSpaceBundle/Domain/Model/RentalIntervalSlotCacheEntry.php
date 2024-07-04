<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

use DateTime;

final class RentalIntervalSlotCacheEntry
{
    private RentalIntervalId $rentalIntervalId;
    private RentalSpaceId $rentalSpaceId;
    private ?RentalPlanId $rentalPlanId;
    private DateTime $dayIndent;
    private ?DateTime $intervalStartTime;
    private ?DateTime $intervalEndTime;
    private ?int $tenancyPrice;
    private ?int $perPersonPrice;
    private ?int $availableSeatsCount;
    private ?DateTime $mostGenerousReservationWindowCloseTime;
    private RentalSlotCacheEntryId $rentalSlotCacheEntryId;
    private ?RentalSlotCacheEntryStatusType $status;

    /**
     * @param RentalSlotCacheEntryId $rentalSlotCacheEntryId
     * @param RentalSpaceId $rentalSpaceId
     * @param RentalPlanId|null $rentalPlanId
     * @param RentalIntervalId $rentalIntervalId
     * @param DateTime $dayIndent
     * @param DateTime|null $intervalStartTime
     * @param DateTime|null $intervalEndTime
     * @param int|null $tenancyPrice
     * @param int|null $perPersonPrice
     * @param int|null $availableSeatsCount
     * @param DateTime|null $mostGenerousReservationWindowCloseTime
     * @param RentalSlotCacheEntryStatusType|null $status
     */
    public function __construct(
        RentalSlotCacheEntryId $rentalSlotCacheEntryId,
        RentalSpaceId $rentalSpaceId,
        ?RentalPlanId $rentalPlanId,
        RentalIntervalId $rentalIntervalId,
        DateTime $dayIndent,
        ?DateTime $intervalStartTime,
        ?DateTime $intervalEndTime,
        ?int $tenancyPrice,
        ?int $perPersonPrice,
        ?int $availableSeatsCount,
        ?DateTime $mostGenerousReservationWindowCloseTime,
        ?RentalSlotCacheEntryStatusType $status
    ){
        $this->availableSeatsCount = $availableSeatsCount;
        $this->perPersonPrice = $perPersonPrice;
        $this->tenancyPrice = $tenancyPrice;
        $this->status = $status;
        $this->mostGenerousReservationWindowCloseTime = $mostGenerousReservationWindowCloseTime;
        $this->intervalEndTime = $intervalEndTime;
        $this->rentalPlanId = $rentalPlanId;
        $this->rentalIntervalId = $rentalIntervalId;
        $this->intervalStartTime = $intervalStartTime;
        $this->dayIndent = $dayIndent;
        $this->rentalSlotCacheEntryId = $rentalSlotCacheEntryId;
        $this->rentalSpaceId = $rentalSpaceId;
    }

    /**
     * @return RentalIntervalId
     */
    public function getRentalIntervalId(): RentalIntervalId
    {
        return $this->rentalIntervalId;
    }

    /**
     * @return RentalSpaceId
     */
    public function getRentalSpaceId(): RentalSpaceId
    {
        return $this->rentalSpaceId;
    }

    /**
     * @return RentalPlanId|null
     */
    public function getRentalPlanId(): ?RentalPlanId
    {
        return $this->rentalPlanId;
    }

    /**
     * @return DateTime
     */
    public function getDayIndent(): DateTime
    {
        return $this->dayIndent;
    }

    /**
     * @return DateTime|null
     */
    public function getIntervalStartTime(): ?DateTime
    {
        return $this->intervalStartTime;
    }

    /**
     * @return DateTime|null
     */
    public function getIntervalEndTime(): ?DateTime
    {
        return $this->intervalEndTime;
    }

    /**
     * @return int|null
     */
    public function getTenancyPrice(): ?int
    {
        return $this->tenancyPrice;
    }

    /**
     * @return int|null
     */
    public function getPerPersonPrice(): ?int
    {
        return $this->perPersonPrice;
    }

    /**
     * @return int|null
     */
    public function getAvailableSeatsCount(): ?int
    {
        return $this->availableSeatsCount;
    }

    /**
     * @return DateTime|null
     */
    public function getMostGenerousReservationWindowCloseTime(): ?DateTime
    {
        return $this->mostGenerousReservationWindowCloseTime;
    }

    /**
     * @return RentalSlotCacheEntryId
     */
    public function getRentalSlotCacheEntryId(): RentalSlotCacheEntryId
    {
        return $this->rentalSlotCacheEntryId;
    }

    /**
     * @return RentalSlotCacheEntryStatusType|null
     */
    public function getStatus(): ?RentalSlotCacheEntryStatusType
    {
        return $this->status;
    }

}
