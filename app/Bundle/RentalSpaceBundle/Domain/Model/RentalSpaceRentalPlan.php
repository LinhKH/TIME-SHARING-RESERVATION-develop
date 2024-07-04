<?php

namespace App\Bundle\RentalSpaceBundle\Domain\Model;

final class RentalSpaceRentalPlan
{
    private ?int $commissionRate;
    private ?array $rentalPlanContiguousUseDiscountRule;
    private ?int $reservationSettingMinContiguousDurationMinutes;
    private ?int $reservationSettingRequiringContiguous;
    private ?int $reservationSettingAllowingMultiBooking;
    private ?int $reservationEarlyNoticeMinutesChooseLaterByCustomer;
    private ?int $reservationEarlyNoticeMinutesPaid;
    private ?int $reservationEarlyNoticeMinutesCashOnSite;
    private ?int $reservationEarlyNoticeMinutesBankTransfer;
    private ?int $reservationEarlyNoticeMinutesCreditCard;
    private ?int $cleaningDurationMinutes;
    private ?int $bankAccountId;
    private ?string $paymentMethodChooseLaterByCustomer;
    private ?string $paymentMethodPaid;
    private ?string $paymentMethodCashOnSite;
    private ?string $paymentMethodBankTransfer;
    private ?string $paymentMethodCreditCard;
    private ?array $dayWhenNotDenyRequest;
    private ?RentalPlanType $reservationType;
    private string $planName;
    private ?string $reservationEarlyNoticeMinutesPaidType;
    private ?string $reservationEarlyNoticeMinutesCashOnSiteType;
    private ?string $reservationEarlyNoticeMinutesBankTransferType;
    private ?string $reservationEarlyNoticeMinutesCreditCardType;
    private ?string $reservationEarlyNoticeMinutesChooseLaterByCustomerType;
    private ?array $reservationOptions;
    private ?RentalSpaceId $rentalSpaceId;
    private ?RentalPlanId $rentalPlanId;
    private ?string $status;

    /**
     * @param RentalSpaceId|null $rentalSpaceId
     * @param RentalPlanId|null $rentalPlanId
     * @param string|null $status
     * @param string $planName
     * @param RentalPlanType|null $reservationType
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
     * @param RentalPlanContiguousUseDiscountRule[]|null $rentalPlanContiguousUseDiscountRule
     * @param int|null $commissionRate
     * @param RentalPlanReservationOptionType[]|null $reservationOptions
     */
    public function __construct(
        ?RentalSpaceId $rentalSpaceId,
        ?RentalPlanId $rentalPlanId,
        ?string $status,
        string $planName,
        ?RentalPlanType $reservationType,
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
        ?array $reservationOptions
    ){
        $this->status = $status;
        $this->rentalPlanId = $rentalPlanId;
        $this->rentalSpaceId = $rentalSpaceId;
        $this->reservationOptions = $reservationOptions;
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

    /**
     * @return RentalSpaceId|null
     */
    public function getRentalSpaceId(): ?RentalSpaceId
    {
        return $this->rentalSpaceId;
    }

    /**
     * @return RentalPlanId|null
     */
    public function getRentalPlanId(): ?RentalPlanId
    {
        return $this->rentalPlanId;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }


    /**
     * @return int|null
     */
    public function getCommissionRate(): ?int
    {
        return $this->commissionRate;
    }

    /**
     * @return RentalPlanContiguousUseDiscountRule[]|null
     */
    public function getRentalPlanContiguousUseDiscountRule(): ?array
    {
        return $this->rentalPlanContiguousUseDiscountRule;
    }

    /**
     * @return int|null
     */
    public function getReservationSettingMinContiguousDurationMinutes(): ?int
    {
        return $this->reservationSettingMinContiguousDurationMinutes;
    }

    /**
     * @return int|null
     */
    public function getReservationSettingRequiringContiguous(): ?int
    {
        return $this->reservationSettingRequiringContiguous;
    }

    /**
     * @return int|null
     */
    public function getReservationSettingAllowingMultiBooking(): ?int
    {
        return $this->reservationSettingAllowingMultiBooking;
    }

    /**
     * @return int|null
     */
    public function getReservationEarlyNoticeMinutesChooseLaterByCustomer(): ?int
    {
        return $this->reservationEarlyNoticeMinutesChooseLaterByCustomer;
    }

    /**
     * @return int|null
     */
    public function getReservationEarlyNoticeMinutesPaid(): ?int
    {
        return $this->reservationEarlyNoticeMinutesPaid;
    }

    /**
     * @return int|null
     */
    public function getReservationEarlyNoticeMinutesCashOnSite(): ?int
    {
        return $this->reservationEarlyNoticeMinutesCashOnSite;
    }

    /**
     * @return int|null
     */
    public function getReservationEarlyNoticeMinutesBankTransfer(): ?int
    {
        return $this->reservationEarlyNoticeMinutesBankTransfer;
    }

    /**
     * @return int|null
     */
    public function getReservationEarlyNoticeMinutesCreditCard(): ?int
    {
        return $this->reservationEarlyNoticeMinutesCreditCard;
    }

    /**
     * @return int|null
     */
    public function getCleaningDurationMinutes(): ?int
    {
        return $this->cleaningDurationMinutes;
    }

    /**
     * @return int|null
     */
    public function getBankAccountId(): ?int
    {
        return $this->bankAccountId;
    }

    /**
     * @return string|null
     */
    public function getPaymentMethodChooseLaterByCustomer(): ?string
    {
        return $this->paymentMethodChooseLaterByCustomer;
    }

    /**
     * @return string|null
     */
    public function getPaymentMethodPaid(): ?string
    {
        return $this->paymentMethodPaid;
    }

    /**
     * @return string|null
     */
    public function getPaymentMethodCashOnSite(): ?string
    {
        return $this->paymentMethodCashOnSite;
    }

    /**
     * @return string|null
     */
    public function getPaymentMethodBankTransfer(): ?string
    {
        return $this->paymentMethodBankTransfer;
    }

    /**
     * @return string|null
     */
    public function getPaymentMethodCreditCard(): ?string
    {
        return $this->paymentMethodCreditCard;
    }

    /**
     * @return array|null
     */
    public function getDayWhenNotDenyRequest(): ?array
    {
        return $this->dayWhenNotDenyRequest;
    }

    /**
     * @return RentalPlanType|null
     */
    public function getReservationType(): ?RentalPlanType
    {
        return $this->reservationType;
    }

    /**
     * @return string
     */
    public function getPlanName(): string
    {
        return $this->planName;
    }

    /**
     * @return string|null
     */
    public function getReservationEarlyNoticeMinutesPaidType(): ?string
    {
        return $this->reservationEarlyNoticeMinutesPaidType;
    }

    /**
     * @return string|null
     */
    public function getReservationEarlyNoticeMinutesCashOnSiteType(): ?string
    {
        return $this->reservationEarlyNoticeMinutesCashOnSiteType;
    }

    /**
     * @return string|null
     */
    public function getReservationEarlyNoticeMinutesBankTransferType(): ?string
    {
        return $this->reservationEarlyNoticeMinutesBankTransferType;
    }

    /**
     * @return string|null
     */
    public function getReservationEarlyNoticeMinutesCreditCardType(): ?string
    {
        return $this->reservationEarlyNoticeMinutesCreditCardType;
    }

    /**
     * @return string|null
     */
    public function getReservationEarlyNoticeMinutesChooseLaterByCustomerType(): ?string
    {
        return $this->reservationEarlyNoticeMinutesChooseLaterByCustomerType;
    }

    /**
     * @return RentalPlanReservationOptionType[]|null
     */
    public function getReservationOptions(): ?array
    {
        return $this->reservationOptions;
    }

}
