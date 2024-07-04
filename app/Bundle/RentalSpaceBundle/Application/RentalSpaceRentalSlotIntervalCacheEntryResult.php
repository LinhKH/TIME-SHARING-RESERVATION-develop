<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpaceRentalSlotIntervalCacheEntryResult
{
    public int $rentalIntervalId;
    public int $rentalSpaceId;
    public ?int $rentalPlanId;
    public string $dayIndent;
    public ?string $intervalEndTime;
    public ?string $intervalStartTime;
    public ?int $tenancyPrice;
    public ?int $perPersonPrice;
    public ?int $availableSeatsCount;
    public ?string $mostGenerousReservationWindowCloseTime;
    public string $rentalSlotCacheEntryId;
    public ?string $status;

    /**
     * @param int $rentalIntervalId
     * @param int $rentalSpaceId
     * @param int|null $rentalPlanId
     * @param string $dayIndent
     * @param string|null $intervalStartTime
     * @param string|null $intervalEndTime
     * @param int|null $tenancyPrice
     * @param int|null $perPersonPrice
     * @param int|null $availableSeatsCount
     * @param string|null $mostGenerousReservationWindowCloseTime
     * @param string $rentalSlotCacheEntryId
     * @param string|null $status
     */
    public function __construct(
        int $rentalIntervalId,
        int $rentalSpaceId,
        ?int $rentalPlanId,
        string $dayIndent,
        ?string $intervalStartTime,
        ?string $intervalEndTime,
        ?int $tenancyPrice,
        ?int $perPersonPrice,
        ?int $availableSeatsCount,
        ?string $mostGenerousReservationWindowCloseTime,
        string $rentalSlotCacheEntryId,
        ?string $status
    ){
        $this->status = $status;
        $this->rentalSlotCacheEntryId = $rentalSlotCacheEntryId;
        $this->mostGenerousReservationWindowCloseTime = $mostGenerousReservationWindowCloseTime;
        $this->availableSeatsCount = $availableSeatsCount;
        $this->perPersonPrice = $perPersonPrice;
        $this->tenancyPrice = $tenancyPrice;
        $this->intervalStartTime = $intervalStartTime;
        $this->intervalEndTime = $intervalEndTime;
        $this->dayIndent = $dayIndent;
        $this->rentalPlanId = $rentalPlanId;
        $this->rentalSpaceId = $rentalSpaceId;
        $this->rentalIntervalId = $rentalIntervalId;
    }
}
