<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

final class RentalSpaceRentalInterval
{

    private ?int $maxSimultaneousPeople;
    private int $maxSimultaneousReservations;
    private ?int $perPersonPrice;
    private ?int $tenancyPrice;
    private ?array $timeFormatted;
    private ?RentalSpaceRentalIntervalMultiType $intervalMulti;
    private RentalSpaceRentalIntervalHolidayApplicabilityType $holidayApplicabilityType;
    private array $applicabilityPeriods;
    private ?RentalPlanId $rentalPlanId;
    private ?array $rentalIntervalIds;
    private ?string $status;


    /**
     * @param RentalPlanId|null $rentalPlanId
     * @param RentalIntervalId[]|null $rentalIntervalIds
     * @param string|null $status
     * @param array $applicabilityPeriods
     * @param RentalSpaceRentalIntervalHolidayApplicabilityType $holidayApplicabilityType
     * @param RentalSpaceRentalIntervalMultiType|null $intervalMulti
     * @param RentalSpaceRentalIntervalTimeFormatted[]|null $timeFormatted
     * @param int|null $tenancyPrice
     * @param int|null $perPersonPrice
     * @param int $maxSimultaneousReservations
     * @param int|null $maxSimultaneousPeople
     */
    public function __construct(
        ?RentalPlanId $rentalPlanId,
        ?array $rentalIntervalIds,
        ?string $status,
        array $applicabilityPeriods,
        RentalSpaceRentalIntervalHolidayApplicabilityType $holidayApplicabilityType,
        ?RentalSpaceRentalIntervalMultiType $intervalMulti,
        ?array $timeFormatted,
        ?int $tenancyPrice,
        ?int $perPersonPrice,
        int $maxSimultaneousReservations,
        ?int $maxSimultaneousPeople
    )
    {
        $this->status = $status;
        $this->rentalIntervalIds = $rentalIntervalIds;
        $this->rentalPlanId = $rentalPlanId;
        $this->applicabilityPeriods = $applicabilityPeriods;
        $this->holidayApplicabilityType = $holidayApplicabilityType;
        $this->intervalMulti = $intervalMulti;
        $this->timeFormatted = $timeFormatted;
        $this->tenancyPrice = $tenancyPrice;
        $this->perPersonPrice = $perPersonPrice;
        $this->maxSimultaneousReservations = $maxSimultaneousReservations;
        $this->maxSimultaneousPeople = $maxSimultaneousPeople;
    }

    /**
     * @return RentalPlanId|null
     */
    public function getRentalPlanId(): ?RentalPlanId
    {
        return $this->rentalPlanId;
    }

    /**
     * @return RentalIntervalId[]|null
     */
    public function getRentalIntervalIds(): ?array
    {
        return $this->rentalIntervalIds;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }


    /**
     * @return int|null
     */
    public function getMaxSimultaneousPeople(): ?int
    {
        return $this->maxSimultaneousPeople;
    }

    /**
     * @return int
     */
    public function getMaxSimultaneousReservations(): int
    {
        return $this->maxSimultaneousReservations;
    }

    /**
     * @return int|null
     */
    public function getPerPersonPrice(): ?int
    {
        return $this->perPersonPrice;
    }

    /**
     * @param int|null $value
     * @return int
     */
    public function setPerPersonPrice(?int $value): int
    {
        return (int) $value;
    }

    /**
     * @return int|null
     */
    public function getTenancyPrice(): ?int
    {
        return $this->tenancyPrice;
    }

    /**
     * @param int|null $value
     * @return int
     */
    public function setTenancyPrice(?int $value): int
    {
        return (int)$value;
    }

    /**
     * @return RentalSpaceRentalIntervalTimeFormatted[]|null
     */
    public function getTimeFormatted(): ?array
    {
        return $this->timeFormatted;
    }



    /**
     * @return RentalSpaceRentalIntervalMultiType|null
     */
    public function getIntervalMulti(): ?RentalSpaceRentalIntervalMultiType
    {
        return $this->intervalMulti;
    }

    /**
     * @return RentalSpaceRentalIntervalHolidayApplicabilityType
     */
    public function getHolidayApplicabilityType(): RentalSpaceRentalIntervalHolidayApplicabilityType
    {
        return $this->holidayApplicabilityType;
    }

    /**
     * @return array
     */
    public function getApplicabilityPeriods(): array
    {
        return $this->applicabilityPeriods;
    }

    /**
     * @param int|null $value
     * @return int
     */
    public function setPerPersonPriceWithFraction(?int $value): int
    {
        return ((int) $value) * 100;
    }

    /**
     * @param $value
     * @return int
     */
    public function setTenancyPriceWithFraction($value): int
    {
        return ((int) $value) * 100;
    }
}
