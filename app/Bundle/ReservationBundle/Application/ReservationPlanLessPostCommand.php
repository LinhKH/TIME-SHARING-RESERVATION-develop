<?php

namespace App\Bundle\ReservationBundle\Application;

final class ReservationPlanLessPostCommand
{

    public int $rentalSpaceId;
    public string $proxyReservationType;
    public string $day;
    public string $planLessStartTime;
    public string $planLessEndTime;
    public string $peopleCount;
    public string $businessStructure;
    public string $usePurposeCategory;
    public string $usePurposeForOther;
    public int $totalPriceOverrideSansTax;
    public ?int $limitedDiscountPriceSansTax;
    public ?int $discount;
    public string $customerEmail;
    public ?string $memoOwner;
    public ?string $memoCustomer;
    public ?string $couponName;
    public ?int $couponId;

    /**
     * @param int $rentalSpaceId
     * @param string $proxyReservationType
     * @param string $day
     * @param string $planLessStartTime
     * @param string $planLessEndTime
     * @param string $peopleCount
     * @param string $businessStructure
     * @param string $usePurposeCategory
     * @param string $usePurposeForOther
     * @param int $totalPriceOverrideSansTax
     * @param int|null $limitedDiscountPriceSansTax
     * @param int|null $discount
     * @param string|null $couponName
     * @param int|null $couponId
     * @param string $customerEmail
     * @param string|null $memoOwner
     * @param string|null $memoCustomer
     */
    public function __construct(
        int $rentalSpaceId,
        string $proxyReservationType,
        string $day,
        string $planLessStartTime,
        string $planLessEndTime,
        string $peopleCount,
        string $businessStructure,
        string $usePurposeCategory,
        string $usePurposeForOther,
        int $totalPriceOverrideSansTax,
        ?int $limitedDiscountPriceSansTax,
        ?int $discount,
        ?string $couponName,
        ?int $couponId,
        string $customerEmail,
        ?string $memoOwner,
        ?string $memoCustomer
    ) {
        $this->couponId = $couponId;
        $this->couponName = $couponName;
        $this->memoCustomer = $memoCustomer;
        $this->memoOwner = $memoOwner;
        $this->customerEmail = $customerEmail;
        $this->limitedDiscountPriceSansTax = $limitedDiscountPriceSansTax;
        $this->totalPriceOverrideSansTax = $totalPriceOverrideSansTax;
        $this->usePurposeForOther = $usePurposeForOther;
        $this->usePurposeCategory = $usePurposeCategory;
        $this->businessStructure = $businessStructure;
        $this->peopleCount = $peopleCount;
        $this->planLessEndTime = $planLessEndTime;
        $this->planLessStartTime = $planLessStartTime;
        $this->day = $day;
        $this->proxyReservationType = $proxyReservationType;
        $this->rentalSpaceId = $rentalSpaceId;
        $this->discount = $discount;
    }
}
