<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

final class RentalSpaceGeneralCancellationFeeRule
{
    private int $startDay;
    private int $endDay;
    private string $isCouponApplicable;
    private int $percentage;


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

    /**
     * @return int
     */
    public function getEndDay(): int
    {
        return $this->endDay;
    }

    /**
     * @return string
     */
    public function getIsCouponApplicable(): string
    {
        return $this->isCouponApplicable;
    }

    /**
     * @return int
     */
    public function getPercentage(): int
    {
        return $this->percentage;
    }

    /**
     * @return int
     */
    public function getStartDay(): int
    {
        return $this->startDay;
    }


}
