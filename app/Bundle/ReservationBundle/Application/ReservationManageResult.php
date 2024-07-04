<?php

namespace App\Bundle\ReservationBundle\Application;

final class ReservationManageResult
{
    public int $reservationId;
    public ReservationManageUserResult $customer;
    public ReservationManageRentalSpaceResult $rentalSpace;
    public string $usePurposeCategory;
    public string $dateOfUse;
    public string $planLessStartTime;
    public string $planLessEndTime;
    public ?string $status;
    public string $registerDateTime;
    public ?ReservationManageCouponResult $couponUsed;
    public ?ReservationManageUserResult $user;

    /**
     * @param int $reservationId
     * @param ReservationManageUserResult $customer
     * @param ReservationManageRentalSpaceResult $rentalSpace
     * @param string $usePurposeCategory
     * @param string $dateOfUse
     * @param string $planLessStartTime
     * @param string $planLessEndTime
     * @param string|null $status
     * @param string $registerDateTime
     * @param ReservationManageCouponResult|null $couponUsed
     * @param ReservationManageUserResult|null $user
     */
    public function __construct(
        int $reservationId,
        ReservationManageUserResult $customer,
        ReservationManageRentalSpaceResult $rentalSpace,
        string $usePurposeCategory,
        string $dateOfUse,
        string $planLessStartTime,
        string $planLessEndTime,
        ?string $status,
        string $registerDateTime,
        ?ReservationManageCouponResult $couponUsed,
        ?ReservationManageUserResult $user
    ){
        $this->couponUsed = $couponUsed;
        $this->registerDateTime = $registerDateTime;
        $this->status = $status;
        $this->planLessEndTime = $planLessEndTime;
        $this->planLessStartTime = $planLessStartTime;
        $this->dateOfUse = $dateOfUse;
        $this->usePurposeCategory = $usePurposeCategory;
        $this->rentalSpace = $rentalSpace;
        $this->customer = $customer;
        $this->reservationId = $reservationId;
        $this->user = $user;
    }

}
