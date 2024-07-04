<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpaceGeneralCancellationFeeRuleCommand
{
    public int $startDay;
    public int $endDay;
    public int $percentage;
    public string $isCouponApplicable;

    /**
     * @param int $startDay
     * @param int $endDay
     * @param int $percentage
     * @param string $isCouponApplicable
     */
    public function __construct(
        int $startDay,
        int $endDay,
        int $percentage,
        string $isCouponApplicable
    ){
        $this->startDay = $startDay;
        $this->endDay = $endDay;
        $this->percentage = $percentage;
        $this->isCouponApplicable = $isCouponApplicable;
    }
}
