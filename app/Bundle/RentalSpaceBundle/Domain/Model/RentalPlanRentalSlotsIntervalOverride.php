<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

final class RentalPlanRentalSlotsIntervalOverride
{
    private RentalPlanId $planId;
    private array $rentalIntervals;
    private ?string $note;
    private int $tenancyPrice;
    private ?int $perPersonPrice;

    /**
     * @param RentalPlanId $planId
     * @param RentalIntervalSlotOverride[] $rentalIntervals
     * @param string|null $note
     * @param int $tenancyPrice
     * @param int|null $perPersonPrice
     */
    public function __construct(
        RentalPlanId $planId,
        array $rentalIntervals,
        ?string $note,
        int $tenancyPrice,
        ?int $perPersonPrice
    ){
        $this->perPersonPrice = $perPersonPrice;
        $this->tenancyPrice = $tenancyPrice;
        $this->note = $note;
        $this->rentalIntervals = $rentalIntervals;
        $this->planId = $planId;
    }

    /**
     * @return RentalPlanId
     */
    public function getPlanId(): RentalPlanId
    {
        return $this->planId;
    }

    /**
     * @return array
     */
    public function getRentalIntervals(): array
    {
        return $this->rentalIntervals;
    }

    /**
     * @return string|null
     */
    public function getNote(): ?string
    {
        return $this->note;
    }

    /**
     * @return int
     */
    public function getTenancyPrice(): int
    {
        return $this->tenancyPrice;
    }

    /**
     * @return int
     */
    public function getTenancyPriceWithFraction(): int
    {
        return $this->tenancyPrice * 100;
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
        return $this->perPersonPrice * 100;
    }
}
