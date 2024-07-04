<?php

namespace App\Bundle\ReservationBundle\Domain\Model;

final class PlanLessCouponDistCount
{
    private ?int $couponId;
    private ?string $couponName;

    public function __construct(
        ?int $couponId,
        ?string $couponName
    ){
        $this->couponName = $couponName;
        $this->couponId = $couponId;
    }

    /**
     * @return int|null
     */
    public function getCouponId(): ?int
    {
        return $this->couponId;
    }

    /**
     * @return string|null
     */
    public function getCouponName(): ?string
    {
        return $this->couponName;
    }

}
