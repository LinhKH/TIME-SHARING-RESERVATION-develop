<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpacePostRentalIntervalCommand
{
    public ?int $maxSimultaneousPeople;
    public int $maxSimultaneousReservations;
    public ?int $perPersonPrice;
    public ?int $tenancyPrice;
    public string $endTimeFormatted;
    public string $startTimeFormatted;
    public int $intervalMulti;
    public int $holidayApplicabilityType;
    public array $applicabilityPeriods;
    public int $rentalSpaceRentalPlanId;
    public int $rentalSpaceId;


    /**
     * @param int $rentalSpaceId
     * @param int $rentalSpaceRentalPlanId
     * @param array $applicabilityPeriods
     * @param int $holidayApplicabilityType
     * @param int $intervalMulti
     * @param string $startTimeFormatted
     * @param string $endTimeFormatted
     * @param int|null $tenancyPrice
     * @param int|null $perPersonPrice
     * @param int $maxSimultaneousReservations
     * @param int|null $maxSimultaneousPeople
     */
    public function __construct(
        int $rentalSpaceId,
        int $rentalSpaceRentalPlanId,
        array $applicabilityPeriods,
        int $holidayApplicabilityType,
        int $intervalMulti,
        string $startTimeFormatted,
        string $endTimeFormatted,
        ?int $tenancyPrice,
        ?int $perPersonPrice,
        int $maxSimultaneousReservations,
        ?int $maxSimultaneousPeople
    ){
        $this->rentalSpaceId = $rentalSpaceId;
        $this->rentalSpaceRentalPlanId = $rentalSpaceRentalPlanId;
        $this->applicabilityPeriods = $applicabilityPeriods;
        $this->holidayApplicabilityType = $holidayApplicabilityType;
        $this->intervalMulti = $intervalMulti;
        $this->startTimeFormatted = $startTimeFormatted;
        $this->endTimeFormatted = $endTimeFormatted;
        $this->tenancyPrice = $tenancyPrice;
        $this->perPersonPrice = $perPersonPrice;
        $this->maxSimultaneousReservations = $maxSimultaneousReservations;
        $this->maxSimultaneousPeople = $maxSimultaneousPeople;
    }

}
