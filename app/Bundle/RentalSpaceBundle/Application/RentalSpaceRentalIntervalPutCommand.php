<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpaceRentalIntervalPutCommand
{

    public ?int $maxSimultaneousPeople;
    public int $maxSimultaneousReservations;
    public ?int $perPersonPrice;
    public ?int $tenancyPrice;
    public ?int $holidayApplicabilityType;
    public ?array $applicabilityPeriods;
    public ?string $status;
    public array $rentalIntervalIds;


    /**
     * @param array $rentalIntervalIds
     * @param string|null $status
     * @param array|null $applicabilityPeriods
     * @param int|null $holidayApplicabilityType
     * @param int|null $tenancyPrice
     * @param int|null $perPersonPrice
     * @param int $maxSimultaneousReservations
     * @param int|null $maxSimultaneousPeople
     */
    public function __construct(
        array $rentalIntervalIds,
        ?string $status,
        ?array $applicabilityPeriods,
        ?int $holidayApplicabilityType,
        ?int $tenancyPrice,
        ?int $perPersonPrice,
        int $maxSimultaneousReservations,
        ?int $maxSimultaneousPeople
    ){
        $this->rentalIntervalIds = $rentalIntervalIds;
        $this->status = $status;
        $this->applicabilityPeriods = $applicabilityPeriods;
        $this->holidayApplicabilityType = $holidayApplicabilityType;
        $this->tenancyPrice = $tenancyPrice;
        $this->perPersonPrice = $perPersonPrice;
        $this->maxSimultaneousReservations = $maxSimultaneousReservations;
        $this->maxSimultaneousPeople = $maxSimultaneousPeople;
    }
}
