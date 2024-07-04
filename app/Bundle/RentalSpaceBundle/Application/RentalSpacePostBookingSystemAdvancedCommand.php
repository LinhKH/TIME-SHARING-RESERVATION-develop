<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpacePostBookingSystemAdvancedCommand
{
    public int $rentalSpaceId;
    public ?int $enableLastMinuteDiscount;
    public ?int $lastMinuteBookDiscountDaysBeforeCount;
    public ?int $lastMinuteBookDiscountPercentage;

    /**
     * @param int $rentalSpaceId
     * @param int|null $enableLastMinuteDiscount
     * @param int|null $lastMinuteBookDiscountDaysBeforeCount
     * @param int|null $lastMinuteBookDiscountPercentage
     */
    public function __construct(
        int $rentalSpaceId,
        ?int $enableLastMinuteDiscount,
        ?int $lastMinuteBookDiscountDaysBeforeCount,
        ?int $lastMinuteBookDiscountPercentage
    )
    {
        $this->lastMinuteBookDiscountPercentage = $lastMinuteBookDiscountPercentage;
        $this->lastMinuteBookDiscountDaysBeforeCount = $lastMinuteBookDiscountDaysBeforeCount;
        $this->enableLastMinuteDiscount = $enableLastMinuteDiscount;
        $this->rentalSpaceId = $rentalSpaceId;
    }
}
