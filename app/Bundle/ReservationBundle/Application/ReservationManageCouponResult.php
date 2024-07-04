<?php

namespace App\Bundle\ReservationBundle\Application;

final class ReservationManageCouponResult
{
    public ?int $couponId;
    public ?string $couponName;
    public ?int $couponDiscountPercentage;

    /**
     * @param int|null $couponId
     * @param string|null $couponName
     * @param int|null $couponDiscountPercentage
     */
    public function __construct(
        ?int $couponId,
        ?string $couponName,
        ?int $couponDiscountPercentage
    )
    {
        $this->couponDiscountPercentage = $couponDiscountPercentage;
        $this->couponName = $couponName;
        $this->couponId = $couponId;
    }
}
