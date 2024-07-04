<?php

namespace App\Bundle\ReservationBundle\Domain\Model;

final class ReservationPlanLess
{
    private PlanLessProxyReservationType $proxyReservationType;
    private string $peopleCount;
    private PlanLessBusinessStructure $businessStructure;
    private string $usePurposeCategory;
    private string $usePurposeForOther;
    private int $totalPriceOverrideSansTax;
    private ?int $limitedDiscountPriceSansTax;
    private ?string $memoOwner;
    private ?string $memoCustomer;
    private ?ReservationId $reservationId;
    private SettingTimeRange $settingTimeRange;
    private DateOfUse $dateOfUse;
    private ?int $distCount;
    private ?PlanLessCouponDistCount $couponDistCount;

    /**
     * @param ReservationId|null $reservationId
     * @param PlanLessProxyReservationType $proxyReservationType
     * @param DateOfUse $dateOfUse
     * @param SettingTimeRange $settingTimeRange
     * @param string $peopleCount
     * @param PlanLessBusinessStructure $businessStructure
     * @param string $usePurposeCategory
     * @param string $usePurposeForOther
     * @param int $totalPriceOverrideSansTax
     * @param int|null $limitedDiscountPriceSansTax
     * @param int|null $distCount
     * @param PlanLessCouponDistCount|null $couponDistCount
     * @param string|null $memoOwner
     * @param string|null $memoCustomer
     */
    public function __construct(
        ?ReservationId $reservationId,
        PlanLessProxyReservationType $proxyReservationType,
        DateOfUse $dateOfUse,
        SettingTimeRange $settingTimeRange,
        string $peopleCount,
        PlanLessBusinessStructure $businessStructure,
        string $usePurposeCategory,
        string $usePurposeForOther,
        int $totalPriceOverrideSansTax,
        ?int $limitedDiscountPriceSansTax,
        ?int $distCount,
        ?PlanLessCouponDistCount $couponDistCount,
        ?string $memoOwner,
        ?string $memoCustomer
    ){
        $this->couponDistCount = $couponDistCount;
        $this->distCount = $distCount;
        $this->settingTimeRange = $settingTimeRange;
        $this->reservationId = $reservationId;
        $this->memoCustomer = $memoCustomer;
        $this->memoOwner = $memoOwner;
        $this->limitedDiscountPriceSansTax = $limitedDiscountPriceSansTax;
        $this->totalPriceOverrideSansTax = $totalPriceOverrideSansTax;
        $this->usePurposeForOther = $usePurposeForOther;
        $this->usePurposeCategory = $usePurposeCategory;
        $this->businessStructure = $businessStructure;
        $this->peopleCount = $peopleCount;
        $this->dateOfUse = $dateOfUse;
        $this->proxyReservationType = $proxyReservationType;

    }

    /**
     * @return PlanLessProxyReservationType
     */
    public function getProxyReservationType(): PlanLessProxyReservationType
    {
        return $this->proxyReservationType;
    }

    /**
     * @return DateOfUse
     */
    public function getDateOfUse(): DateOfUse
    {
        return $this->dateOfUse;
    }

    /**
     * @return SettingTimeRange
     */
    public function getSettingTimeRange(): SettingTimeRange
    {
        return $this->settingTimeRange;
    }


    /**
     * @return string
     */
    public function getPeopleCount(): string
    {
        return $this->peopleCount;
    }

    /**
     * @return PlanLessBusinessStructure
     */
    public function getBusinessStructure(): PlanLessBusinessStructure
    {
        return $this->businessStructure;
    }

    /**
     * @return string
     */
    public function getUsePurposeCategory(): string
    {
        return $this->usePurposeCategory;
    }

    /**
     * @return string
     */
    public function getUsePurposeForOther(): string
    {
        return $this->usePurposeForOther;
    }

    /**
     * @return int
     */
    public function getTotalPriceOverrideSansTax(): int
    {
        return $this->totalPriceOverrideSansTax;
    }

    /**
     * @return int|null
     */
    public function getLimitedDiscountPriceSansTax(): ?int
    {
        return $this->limitedDiscountPriceSansTax;
    }

    /**
     * @return string|null
     */
    public function getMemoOwner(): ?string
    {
        return $this->memoOwner;
    }

    /**
     * @return string|null
     */
    public function getMemoCustomer(): ?string
    {
        return $this->memoCustomer;
    }

    /**
     * @return ReservationId|null
     */
    public function getReservationId(): ?ReservationId
    {
        return $this->reservationId;
    }

    /**
     * @return int|null
     */
    public function getDistCount(): ?int
    {
        return $this->distCount;
    }

    /**
     * @return PlanLessCouponDistCount|null
     */
    public function getCouponDistCount(): ?PlanLessCouponDistCount
    {
        return $this->couponDistCount;
    }

    /**
     * @return float|int
     */
    public function setPriceSansTaxWithFraction()
    {
        $distCountPrice = 0;
        $distCount = $this->distCount ?? null;
        if (!empty($distCount)) {
            $distCountPrice = ($this->totalPriceOverrideSansTax * $this->distCount) / 100;
        }
        return ($this->totalPriceOverrideSansTax - $distCountPrice) * 100;
    }

    /**
     * @return float|int
     */
    public function setPriceSansTax()
    {
        $distCountPrice = 0;
        $distCount = $this->distCount ?? null;
        if (!empty($distCount)) {
            $distCountPrice = ($this->totalPriceOverrideSansTax * $this->distCount) / 100;
        }
        return $this->totalPriceOverrideSansTax - $distCountPrice;
    }

    /**
     * @return float|int
     */
    public function setCouponSansTax()
    {
        $distCountPrice = 0;
        if (!empty($distCount)) {
            $distCountPrice = ($this->totalPriceOverrideSansTax * $this->distCount) / 100;
        }
        return $distCountPrice;
    }

    /**
     * @return float|int
     */
    public function setCouponSansTaxWithFraction()
    {
        $distCountPrice = 0;
        if (!empty($distCount)) {
            $distCountPrice = ($this->totalPriceOverrideSansTax * $this->distCount) / 100;
        }
        return $distCountPrice * 100;
    }
}
