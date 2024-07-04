<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

final class RentalPlanContiguousUseDiscountRule
{
    private int $totalMinuteTimeOfTheFrame;
    private int $discountFromTotalAmount;
    private string $totalMinuteTimeOfTheFrameType;
    private string $discountFromTotalAmountType;

    /**
     * @param int $totalMinuteTimeOfTheFrame
     * @param string $totalMinuteTimeOfTheFrameType
     * @param int $discountFromTotalAmount
     * @param string $discountFromTotalAmountType
     */
    public function __construct(
        int $totalMinuteTimeOfTheFrame,
        string $totalMinuteTimeOfTheFrameType,
        int $discountFromTotalAmount,
        string $discountFromTotalAmountType
    ){
        $this->discountFromTotalAmountType = $discountFromTotalAmountType;
        $this->totalMinuteTimeOfTheFrameType = $totalMinuteTimeOfTheFrameType;
        $this->discountFromTotalAmount = $discountFromTotalAmount;
        $this->totalMinuteTimeOfTheFrame = $totalMinuteTimeOfTheFrame;
    }

    /**
     * @return int
     */
    public function getTotalMinuteTimeOfTheFrame(): int
    {
        return $this->totalMinuteTimeOfTheFrame;
    }

    /**
     * @return int
     */
    public function getDiscountFromTotalAmount(): int
    {
        return $this->discountFromTotalAmount;
    }

    /**
     * @return string
     */
    public function getTotalMinuteTimeOfTheFrameType(): string
    {
        return $this->totalMinuteTimeOfTheFrameType;
    }

    /**
     * @return string
     */
    public function getDiscountFromTotalAmountType(): string
    {
        return $this->discountFromTotalAmountType;
    }

}
