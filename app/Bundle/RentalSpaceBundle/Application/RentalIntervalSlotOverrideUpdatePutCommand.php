<?php

namespace App\Bundle\RentalSpaceBundle\Application;

class RentalIntervalSlotOverrideUpdatePutCommand
{
    public int $planId;
    public array $rentalIntervals;
    public ?string $note;
    public int $tenancyPrice;
    public ?int $perPersonPrice;
    public int $spaceId;

    /**
     * @param int $spaceId
     * @param int $planId
     * @param RentalIntervalSlotOverride[] $rentalIntervals
     * @param string|null $note
     * @param int $tenancyPrice
     * @param int|null $perPersonPrice
     */
    public function __construct(
        int $spaceId,
        int $planId,
        array $rentalIntervals,
        ?string $note,
        int $tenancyPrice,
        ?int $perPersonPrice
    ){
        $this->spaceId = $spaceId;
        $this->perPersonPrice = $perPersonPrice;
        $this->tenancyPrice = $tenancyPrice;
        $this->note = $note;
        $this->rentalIntervals = $rentalIntervals;
        $this->planId = $planId;
    }
}
