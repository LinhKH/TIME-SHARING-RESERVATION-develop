<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpaceRentalIntervalResult
{
    public int $id;
    public array $applicabilityPeriods;
    public string $endTimeFormatted;
    public string $startTimeFormatted;
    public int $holidayApplicabilityType;
    public string $status;
    public ?int $tenancyPrice;
    public ?int $tenancyPriceWithFraction;
    public ?int $perPersonPrice;
    public ?int $perPersonPriceWithFraction;
    public int $maxSimultaneousReservations;
    public ?int $maxSimultaneousPeople;


    /**
     * @param int $id
     * @param array $applicabilityPeriods
     * @param string $endTimeFormatted
     * @param string $startTimeFormatted
     * @param int $holidayApplicabilityType
     * @param string $status
     * @param int|null $tenancyPrice
     * @param int|null $tenancyPriceWithFraction
     * @param int|null $perPersonPrice
     * @param int|null $perPersonPriceWithFraction
     * @param int $maxSimultaneousReservations
     * @param int|null $maxSimultaneousPeople
     */
    public function __construct(
        int $id,
        array $applicabilityPeriods,
        string $endTimeFormatted,
        string $startTimeFormatted,
        int $holidayApplicabilityType,
        string $status,
        ?int $tenancyPrice,
        ?int $tenancyPriceWithFraction,
        ?int $perPersonPrice,
        ?int $perPersonPriceWithFraction,
        int $maxSimultaneousReservations,
        ?int $maxSimultaneousPeople
    )
    {
        $this->maxSimultaneousPeople = $maxSimultaneousPeople;
        $this->maxSimultaneousReservations = $maxSimultaneousReservations;
        $this->perPersonPriceWithFraction = $perPersonPriceWithFraction;
        $this->perPersonPrice = $perPersonPrice;
        $this->tenancyPriceWithFraction = $tenancyPriceWithFraction;
        $this->tenancyPrice = $tenancyPrice;
        $this->status = $status;
        $this->holidayApplicabilityType = $holidayApplicabilityType;
        $this->startTimeFormatted = $startTimeFormatted;
        $this->endTimeFormatted = $endTimeFormatted;
        $this->applicabilityPeriods = $applicabilityPeriods;
        $this->id = $id;
    }
}
