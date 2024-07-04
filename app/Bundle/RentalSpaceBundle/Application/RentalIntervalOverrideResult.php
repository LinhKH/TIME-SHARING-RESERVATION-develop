<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalIntervalOverrideResult
{
    public string $rentalIntervalOverrideId;
    public int $rentalIntervalId;
    public string $dayIndent;
    public string $intervalStartTime;
    public string $intervalEndTime;
    public ?int $tenancyPrice;

    /**
     * @param string $rentalIntervalOverrideId
     * @param int $rentalIntervalId
     * @param string $dayIndent
     * @param string $intervalStartTime
     * @param string $intervalEndTime
     * @param int|null $tenancyPrice
     */
    public function __construct(
        string $rentalIntervalOverrideId,
        int $rentalIntervalId,
        string $dayIndent,
        string $intervalStartTime,
        string $intervalEndTime,
        ?int $tenancyPrice

    ){
        $this->tenancyPrice = $tenancyPrice;
        $this->intervalEndTime = $intervalEndTime;
        $this->intervalStartTime = $intervalStartTime;
        $this->dayIndent = $dayIndent;
        $this->rentalIntervalId = $rentalIntervalId;
        $this->rentalIntervalOverrideId = $rentalIntervalOverrideId;
    }
}
