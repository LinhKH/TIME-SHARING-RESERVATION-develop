<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpaceRentalSlotIntervalUnavailableCacheEntryInThisDayGetCommand
{
    public int $rentalSpaceId;
    public int $rentalPlanId;
    public int $month;
    public int $year;

    /**
     * @param int $rentalSpaceId
     * @param int $rentalPlanId
     * @param int $month
     * @param int $year
     */
    public function __construct(
        int $rentalSpaceId,
        int $rentalPlanId,
        int $month,
        int $year

    )
    {
        $this->year = $year;
        $this->month = $month;
        $this->rentalPlanId = $rentalPlanId;
        $this->rentalSpaceId = $rentalSpaceId;
    }
}
