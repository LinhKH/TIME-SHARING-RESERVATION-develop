<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

final class RentalIntervalInformation
{
    private int $id;
    private array $applicabilityPeriods;
    private string $endTimeFormatted;
    private string $startTimeFormatted;
    private string $holidayApplicabilityType;
    private string $status;
    private ?int $tenancyPrice;
    private ?int $tenancyPriceWithFraction;
    private ?int $perPersonPrice;
    private ?int $perPersonPriceWithFraction;
    private int $maxSimultaneousReservations;
    private ?int $maxSimultaneousPeople;


    /**
     * @param int $id
     * @param array $applicabilityPeriods
     * @param string $endTimeFormatted
     * @param string $startTimeFormatted
     * @param string $holidayApplicabilityType
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
        string $holidayApplicabilityType,
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

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getApplicabilityPeriods(): array
    {
        return $this->applicabilityPeriods;
    }

    /**
     * @return string
     */
    public function getEndTimeFormatted(): string
    {
        return $this->endTimeFormatted;
    }

    /**
     * @return string
     */
    public function getStartTimeFormatted(): string
    {
        return $this->startTimeFormatted;
    }

    /**
     * @return string
     */
    public function getHolidayApplicabilityType(): string
    {
        return $this->holidayApplicabilityType;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return int|null
     */
    public function getTenancyPrice(): ?int
    {
        return $this->tenancyPrice;
    }

    /**
     * @return int|null
     */
    public function getTenancyPriceWithFraction(): ?int
    {
        return $this->tenancyPriceWithFraction;
    }

    /**
     * @return int|null
     */
    public function getPerPersonPrice(): ?int
    {
        return $this->perPersonPrice;
    }

    /**
     * @return int|null
     */
    public function getPerPersonPriceWithFraction(): ?int
    {
        return $this->perPersonPriceWithFraction;
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
    public function getMaxSimultaneousPeople(): ?int
    {
        return $this->maxSimultaneousPeople;
    }

}
