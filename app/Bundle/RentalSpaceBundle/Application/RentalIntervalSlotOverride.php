<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalIntervalSlotOverride
{
    public int $rentalIntervalId;
    public string $dayIndent;
    public string $intervalStartTime;
    public string $intervalEndTime;

    /**
     * @param int $rentalIntervalId
     * @param string $dayIndent
     * @param string $intervalStartTime
     * @param string $intervalEndTime
     */
    public function __construct(
        int $rentalIntervalId,
        string $dayIndent,
        string $intervalStartTime,
        string $intervalEndTime
    ){
        $this->intervalEndTime = $intervalEndTime;
        $this->intervalStartTime = $intervalStartTime;
        $this->dayIndent = $dayIndent;
        $this->rentalIntervalId = $rentalIntervalId;
    }
}
