<?php

namespace App\Bundle\ReservationBundle\Domain\Model;

use App\Bundle\CustomerBundle\Domain\Model\CustomerId;
use App\Bundle\RentalSpaceBundle\Domain\Model\RentalSpaceId;
use App\Bundle\UserBundle\Domain\Model\UserId;

final class ReservationManage
{
    private ReservationId $reservationId;
    private string $usePurposeCategory;
    private DateOfUse $dateOfUse;
    private SettingTimeRange $settingTimeRange;
    private ?string $status;
    private DateTimeConvert $registerDateTime;
    private ?int $couponId;
    private ?string $couponName;
    private ?int $couponDiscountPercentage;
    private CustomerId $customerId;
    private UserId $userId;
    private RentalSpaceId $rentalSpaceId;

    /**
     * @param ReservationId $reservationId
     * @param string $usePurposeCategory
     * @param DateOfUse $dateOfUse
     * @param SettingTimeRange $settingTimeRange
     * @param string|null $status
     * @param DateTimeConvert $registerDateTime
     * @param int|null $couponId
     * @param string|null $couponName
     * @param int|null $couponDiscountPercentage
     * @param CustomerId $customerId
     * @param UserId $userId
     * @param RentalSpaceId $rentalSpaceId
     */
    public function __construct(
        ReservationId $reservationId,
        string $usePurposeCategory,
        DateOfUse $dateOfUse,
        SettingTimeRange $settingTimeRange,
        ?string $status,
        DateTimeConvert $registerDateTime,
        ?int $couponId,
        ?string $couponName,
        ?int $couponDiscountPercentage,
        CustomerId $customerId,
        UserId $userId,
        RentalSpaceId $rentalSpaceId
    ){
        $this->settingTimeRange = $settingTimeRange;
        $this->rentalSpaceId = $rentalSpaceId;
        $this->userId = $userId;
        $this->customerId = $customerId;
        $this->couponDiscountPercentage = $couponDiscountPercentage;
        $this->couponName = $couponName;
        $this->couponId = $couponId;
        $this->registerDateTime = $registerDateTime;
        $this->status = $status;
        $this->dateOfUse = $dateOfUse;
        $this->usePurposeCategory = $usePurposeCategory;
        $this->reservationId = $reservationId;
    }

    /**
     * @return ReservationId
     */
    public function getReservationId(): ReservationId
    {
        return $this->reservationId;
    }

    /**
     * @return string
     */
    public function getUsePurposeCategory(): string
    {
        return $this->usePurposeCategory;
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
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @return DateTimeConvert
     */
    public function getRegisterDateTime(): DateTimeConvert
    {
        return $this->registerDateTime;
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

    /**
     * @return int|null
     */
    public function getCouponDiscountPercentage(): ?int
    {
        return $this->couponDiscountPercentage;
    }

    /**
     * @return CustomerId
     */
    public function getCustomerId(): CustomerId
    {
        return $this->customerId;
    }

    /**
     * @return UserId
     */
    public function getUserId(): UserId
    {
        return $this->userId;
    }

    /**
     * @return RentalSpaceId
     */
    public function getRentalSpaceId(): RentalSpaceId
    {
        return $this->rentalSpaceId;
    }

}
