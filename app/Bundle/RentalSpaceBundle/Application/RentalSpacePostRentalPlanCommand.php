<?php

namespace App\Bundle\RentalSpaceBundle\Application;

final class RentalSpacePostRentalPlanCommand
{
    public int $rentalSpaceId;
    public string $planName;
    public ?string $reservationType;
    public ?array $dayWhenNotDenyRequest;
    public ?string $paymentMethodCreditCard;
    public ?string $paymentMethodBankTransfer;
    public ?string $paymentMethodCashOnSite;
    public ?string $paymentMethodPaid;
    public ?string $paymentMethodChooseLaterByCustomer;
    public ?int $bankAccountId;
    public ?int $cleaningDurationMinutes;
    public ?int $reservationEarlyNoticeMinutesCreditCard;
    public ?int $reservationEarlyNoticeMinutesBankTransfer;
    public ?int $reservationEarlyNoticeMinutesCashOnSite;
    public ?int $reservationEarlyNoticeMinutesPaid;
    public ?int $reservationEarlyNoticeMinutesChooseLaterByCustomer;
    public ?int $reservationSettingAllowingMultiBooking;
    public ?int $reservationSettingRequiringContiguous;
    public ?int $reservationSettingMinContiguousDurationMinutes;
    public ?array $rentalPlanContiguousUseDiscountRuleCommand;
    public ?int $commissionRate;
    public ?string $reservationEarlyNoticeMinutesCreditCardType;
    public ?string $reservationEarlyNoticeMinutesBankTransferType;
    public ?string $reservationEarlyNoticeMinutesPaidType;
    public ?string $reservationEarlyNoticeMinutesChooseLaterByCustomerType;
    public ?string $reservationEarlyNoticeMinutesCashOnSiteType;
    public ?array $reservationOptions;

    /**
     * @param int $rentalSpaceId
     * @param string $planName
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
     * @param RentalPlanContiguousUseDiscountRuleCommand[]|null $rentalPlanContiguousUseDiscountRuleCommand
     * @param int|null $commissionRate
     * @param RentalPlanReservationOptionTypeCommand[]|null $reservationOptions
     */
    public function __construct(
        int $rentalSpaceId,
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
        ?array $rentalPlanContiguousUseDiscountRuleCommand,
        ?int $commissionRate,
        ?array $reservationOptions
    ){
        $this->reservationOptions = $reservationOptions;
        $this->reservationEarlyNoticeMinutesCashOnSiteType = $reservationEarlyNoticeMinutesCashOnSiteType;
        $this->reservationEarlyNoticeMinutesChooseLaterByCustomerType = $reservationEarlyNoticeMinutesChooseLaterByCustomerType;
        $this->reservationEarlyNoticeMinutesPaidType = $reservationEarlyNoticeMinutesPaidType;
        $this->reservationEarlyNoticeMinutesBankTransferType = $reservationEarlyNoticeMinutesBankTransferType;
        $this->reservationEarlyNoticeMinutesCreditCardType = $reservationEarlyNoticeMinutesCreditCardType;
        $this->rentalSpaceId = $rentalSpaceId;
        $this->commissionRate = $commissionRate;
        $this->rentalPlanContiguousUseDiscountRuleCommand = $rentalPlanContiguousUseDiscountRuleCommand;
        $this->reservationSettingMinContiguousDurationMinutes = $reservationSettingMinContiguousDurationMinutes;
        $this->reservationSettingRequiringContiguous = $reservationSettingRequiringContiguous;
        $this->reservationSettingAllowingMultiBooking = $reservationSettingAllowingMultiBooking;
        $this->reservationEarlyNoticeMinutesChooseLaterByCustomer = $reservationEarlyNoticeMinutesChooseLaterByCustomer;
        $this->reservationEarlyNoticeMinutesPaid = $reservationEarlyNoticeMinutesPaid;
        $this->reservationEarlyNoticeMinutesCashOnSite = $reservationEarlyNoticeMinutesCashOnSite;
        $this->reservationEarlyNoticeMinutesBankTransfer = $reservationEarlyNoticeMinutesBankTransfer;
        $this->reservationEarlyNoticeMinutesCreditCard = $reservationEarlyNoticeMinutesCreditCard;
        $this->cleaningDurationMinutes = $cleaningDurationMinutes;
        $this->bankAccountId = $bankAccountId;
        $this->paymentMethodChooseLaterByCustomer = $paymentMethodChooseLaterByCustomer;
        $this->paymentMethodPaid = $paymentMethodPaid;
        $this->paymentMethodCashOnSite = $paymentMethodCashOnSite;
        $this->paymentMethodBankTransfer = $paymentMethodBankTransfer;
        $this->paymentMethodCreditCard = $paymentMethodCreditCard;
        $this->dayWhenNotDenyRequest = $dayWhenNotDenyRequest;
        $this->reservationType = $reservationType;
        $this->planName = $planName;
    }
}
