<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpaceGetDetailRentalPlanResult
{
    public ?int $commissionRate;
    public ?array $rentalPlanContiguousUseDiscountRule;
    public ?int $reservationSettingMinContiguousDurationMinutes;
    public ?int $reservationSettingRequiringContiguous;
    public ?int $reservationSettingAllowingMultiBooking;
    public ?int $reservationEarlyNoticeMinutesChooseLaterByCustomer;
    public ?int $reservationEarlyNoticeMinutesPaid;
    public ?int $reservationEarlyNoticeMinutesCashOnSite;
    public ?int $reservationEarlyNoticeMinutesBankTransfer;
    public ?int $reservationEarlyNoticeMinutesCreditCard;
    public ?int $cleaningDurationMinutes;
    public ?int $bankAccountId;
    public ?string $paymentMethodChooseLaterByCustomer;
    public ?string $paymentMethodPaid;
    public ?string $paymentMethodCashOnSite;
    public ?string $paymentMethodBankTransfer;
    public ?string $paymentMethodCreditCard;
    public ?array $dayWhenNotDenyRequest;
    public ?string $reservationType;
    public string $planName;
    public ?string $reservationEarlyNoticeMinutesPaidType;
    public ?string $reservationEarlyNoticeMinutesCashOnSiteType;
    public ?string $reservationEarlyNoticeMinutesBankTransferType;
    public ?string $reservationEarlyNoticeMinutesCreditCardType;
    public ?string $reservationEarlyNoticeMinutesChooseLaterByCustomerType;
    public ?array $planImage;
    public ?array $reservationOptions;
    public ?string $status;

    /**
     * @param string $planName
     * @param string|null $status
     * @param string|null $reservationType
     * @param array|null $dayWhenNotDenyRequest
     * @param string|null $paymentMethodCreditCard
     * @param string|null $paymentMethodBankTransfer
     * @param string|null $paymentMethodCashOnSite
     * @param string|null $paymentMethodPaid
     * @param string|null $paymentMethodChooseLaterByCustomer
     * @param int|null $bankAccountId
     * @param int|null $cleaningDurationMinutes
     * @param int|null $reservationEarlyNoticeMinutesCreditCard
     * @param string|null $reservationEarlyNoticeMinutesCreditCardType
     * @param int|null $reservationEarlyNoticeMinutesBankTransfer
     * @param string|null $reservationEarlyNoticeMinutesBankTransferType
     * @param int|null $reservationEarlyNoticeMinutesCashOnSite
     * @param string|null $reservationEarlyNoticeMinutesCashOnSiteType
     * @param int|null $reservationEarlyNoticeMinutesPaid
     * @param string|null $reservationEarlyNoticeMinutesPaidType
     * @param int|null $reservationEarlyNoticeMinutesChooseLaterByCustomer
     * @param string|null $reservationEarlyNoticeMinutesChooseLaterByCustomerType
     * @param int|null $reservationSettingAllowingMultiBooking
     * @param int|null $reservationSettingRequiringContiguous
     * @param int|null $reservationSettingMinContiguousDurationMinutes
     * @param RentalPlanContiguousUseDiscountRuleResult[]|null $rentalPlanContiguousUseDiscountRule
     * @param int|null $commissionRate
     * @param array|null $planImage
     * @param RentalPlanReservationOptionTypeResult[]|null $reservationOptions
     */
    public function __construct(
        ?string $status,
        string $planName,
        ?string $reservationType,
        ?array $dayWhenNotDenyRequest,
        ?string $paymentMethodCreditCard,
        ?string $paymentMethodBankTransfer,
        ?string $paymentMethodCashOnSite,
        ?string $paymentMethodPaid,
        ?string $paymentMethodChooseLaterByCustomer,
        ?int $bankAccountId,
        ?int $cleaningDurationMinutes,
        ?int $reservationEarlyNoticeMinutesCreditCard,
        ?string $reservationEarlyNoticeMinutesCreditCardType,
        ?int $reservationEarlyNoticeMinutesBankTransfer,
        ?string $reservationEarlyNoticeMinutesBankTransferType,
        ?int $reservationEarlyNoticeMinutesCashOnSite,
        ?string $reservationEarlyNoticeMinutesCashOnSiteType,
        ?int $reservationEarlyNoticeMinutesPaid,
        ?string $reservationEarlyNoticeMinutesPaidType,
        ?int $reservationEarlyNoticeMinutesChooseLaterByCustomer,
        ?string $reservationEarlyNoticeMinutesChooseLaterByCustomerType,
        ?int $reservationSettingAllowingMultiBooking,
        ?int $reservationSettingRequiringContiguous,
        ?int $reservationSettingMinContiguousDurationMinutes,
        ?array $rentalPlanContiguousUseDiscountRule,
        ?int $commissionRate,
        ?array $planImage,
        ?array $reservationOptions
    ){
        $this->reservationOptions = $reservationOptions;
        $this->status = $status;
        $this->planImage = $planImage;
        $this->reservationEarlyNoticeMinutesCreditCardType = $reservationEarlyNoticeMinutesCreditCardType;
        $this->reservationEarlyNoticeMinutesBankTransferType = $reservationEarlyNoticeMinutesBankTransferType;
        $this->reservationEarlyNoticeMinutesCashOnSiteType = $reservationEarlyNoticeMinutesCashOnSiteType;
        $this->reservationEarlyNoticeMinutesPaidType = $reservationEarlyNoticeMinutesPaidType;
        $this->reservationEarlyNoticeMinutesChooseLaterByCustomerType = $reservationEarlyNoticeMinutesChooseLaterByCustomerType;
        $this->planName = $planName;
        $this->reservationType = $reservationType;
        $this->dayWhenNotDenyRequest = $dayWhenNotDenyRequest;
        $this->paymentMethodCreditCard = $paymentMethodCreditCard;
        $this->paymentMethodBankTransfer = $paymentMethodBankTransfer;
        $this->paymentMethodCashOnSite = $paymentMethodCashOnSite;
        $this->paymentMethodPaid = $paymentMethodPaid;
        $this->paymentMethodChooseLaterByCustomer = $paymentMethodChooseLaterByCustomer;
        $this->bankAccountId = $bankAccountId;
        $this->cleaningDurationMinutes = $cleaningDurationMinutes;
        $this->reservationEarlyNoticeMinutesCreditCard = $reservationEarlyNoticeMinutesCreditCard;
        $this->reservationEarlyNoticeMinutesBankTransfer = $reservationEarlyNoticeMinutesBankTransfer;
        $this->reservationEarlyNoticeMinutesCashOnSite = $reservationEarlyNoticeMinutesCashOnSite;
        $this->reservationEarlyNoticeMinutesPaid = $reservationEarlyNoticeMinutesPaid;
        $this->reservationEarlyNoticeMinutesChooseLaterByCustomer = $reservationEarlyNoticeMinutesChooseLaterByCustomer;
        $this->reservationSettingAllowingMultiBooking = $reservationSettingAllowingMultiBooking;
        $this->reservationSettingRequiringContiguous = $reservationSettingRequiringContiguous;
        $this->reservationSettingMinContiguousDurationMinutes = $reservationSettingMinContiguousDurationMinutes;
        $this->rentalPlanContiguousUseDiscountRule = $rentalPlanContiguousUseDiscountRule;
        $this->commissionRate = $commissionRate;
    }
}
