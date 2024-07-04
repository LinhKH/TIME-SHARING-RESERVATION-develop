<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

final class RentalSpaceBookingSystemAdvanced
{
    private RentalSpaceId $rentalSpaceId;
    private ?int $enableLastMinuteDiscount;
    private ?int $lastMinuteBookDiscountDaysBeforeCount;
    private ?int $lastMinuteBookDiscountPercentage;

    public function __construct(
        RentalSpaceId $rentalSpaceId,
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

    /**
     * @return RentalSpaceId
     */
    public function getRentalSpaceId(): RentalSpaceId
    {
        return $this->rentalSpaceId;
    }

    /**
     * @return int|null
     */
    public function getEnableLastMinuteDiscount(): ?int
    {
        return $this->enableLastMinuteDiscount;
    }

    /**
     * @return int|null
     */
    public function getLastMinuteBookDiscountDaysBeforeCount(): ?int
    {
        return $this->lastMinuteBookDiscountDaysBeforeCount;
    }

    /**
     * @return int|null
     */
    public function getLastMinuteBookDiscountPercentage(): ?int
    {
        return $this->lastMinuteBookDiscountPercentage;
    }

}
