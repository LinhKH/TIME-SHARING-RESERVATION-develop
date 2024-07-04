<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalPlanContiguousUseDiscountRuleCommand
{
    public int $totalMinuteTimeOfTheFrame;
    public int $discountFromTotalAmount;
    public string $totalMinuteTimeOfTheFrameType;
    public string $discountFromTotalAmountType;

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
        $this->totalMinuteTimeOfTheFrame = $totalMinuteTimeOfTheFrame;
        $this->totalMinuteTimeOfTheFrameType = $totalMinuteTimeOfTheFrameType;
        $this->discountFromTotalAmount = $discountFromTotalAmount;
        $this->discountFromTotalAmountType = $discountFromTotalAmountType;
    }
}
