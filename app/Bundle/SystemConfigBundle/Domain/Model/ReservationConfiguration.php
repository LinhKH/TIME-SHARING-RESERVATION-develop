<?php

namespace App\Bundle\SystemConfigBundle\Domain\Model;

final class ReservationConfiguration
{
    private ?int $maxRentalPlansCount;
    private ?int $maxRentalPlanIntervalsCount;
    private ?string $bookingSystemInformationLink;
    private ?int $handlingFeePercentage;
    private ?int $ccChargingFeePercentage;
    private ?int $reservationRequestsConfirmationTimeout;
    private ?int $reservationRequestsFirstConfirmationReminderSendingTime;
    private ?int $reservationRequestsSecondConfirmationReminderSendingTime;
    private ?int $spaceUsageReminderSendingHour;
    private ?string $excludeSpaceIdsInitialValue;

    /**
     * @param int|null $maxRentalPlansCount maxRentalPlansCount
     * @param int|null $maxRentalPlanIntervalsCount maxRentalPlanIntervalsCount
     * @param string|null $bookingSystemInformationLink bookingSystemInformationLink
     * @param int|null $handlingFeePercentage handlingFeePercentage
     * @param int|null $ccChargingFeePercentage ccChargingFeePercentage
     * @param int|null $reservationRequestsConfirmationTimeout reservationRequestsConfirmationTimeout
     * @param int|null $reservationRequestsFirstConfirmationReminderSendingTime reservationRequestsFirstConfirmationReminderSendingTime
     * @param int|null $reservationRequestsSecondConfirmationReminderSendingTime reservationRequestsSecondConfirmationReminderSendingTime
     * @param int|null $spaceUsageReminderSendingHour spaceUsageReminderSendingHour
     * @param string|null $excludeSpaceIdsInitialValue excludeSpaceIdsInitialValue
     */
    public function __construct(
        ?int $maxRentalPlansCount,
        ?int $maxRentalPlanIntervalsCount,
        ?string $bookingSystemInformationLink,
        ?int $handlingFeePercentage,
        ?int $ccChargingFeePercentage,
        ?int  $reservationRequestsConfirmationTimeout,
        ?int $reservationRequestsFirstConfirmationReminderSendingTime,
        ?int $reservationRequestsSecondConfirmationReminderSendingTime,
        ?int $spaceUsageReminderSendingHour,
        ?string $excludeSpaceIdsInitialValue
    ) {
        $this->maxRentalPlansCount = $maxRentalPlansCount;
        $this->maxRentalPlanIntervalsCount = $maxRentalPlanIntervalsCount;
        $this->bookingSystemInformationLink = $bookingSystemInformationLink;
        $this->handlingFeePercentage = $handlingFeePercentage;
        $this->ccChargingFeePercentage = $ccChargingFeePercentage;
        $this->reservationRequestsConfirmationTimeout = $reservationRequestsConfirmationTimeout;
        $this->reservationRequestsFirstConfirmationReminderSendingTime = $reservationRequestsFirstConfirmationReminderSendingTime;
        $this->reservationRequestsSecondConfirmationReminderSendingTime = $reservationRequestsSecondConfirmationReminderSendingTime;
        $this->spaceUsageReminderSendingHour = $spaceUsageReminderSendingHour;
        $this->excludeSpaceIdsInitialValue = $excludeSpaceIdsInitialValue;
    }

    /**
     * @return int|null
     */
    public function getMaxRentalPlansCount(): ?int
    {
        return $this->maxRentalPlansCount;
    }

    /**
     * @return int|null
     */
    public function getMaxRentalPlanIntervalsCount(): ?int
    {
        return $this->maxRentalPlanIntervalsCount;
    }

    /**
     * @return string|null
     */
    public function getBookingSystemInformationLink(): ?string
    {
        return $this->bookingSystemInformationLink;
    }

    /**
     * @return int|null
     */
    public function getHandlingFeePercentage(): ?int
    {
        return $this->handlingFeePercentage;
    }

    /**
     * @return int|null
     */
    public function getCcChargingFeePercentage(): ?int
    {
        return $this->ccChargingFeePercentage;
    }

    /**
     * @return int|null
     */
    public function getReservationRequestsConfirmationTimeout(): ?int
    {
        return $this->reservationRequestsConfirmationTimeout;
    }

    /**
     * @return int|null
     */
    public function getReservationRequestsFirstConfirmationReminderSendingTime(): ?int
    {
        return $this->reservationRequestsFirstConfirmationReminderSendingTime;
    }

    /**
     * @return int|null
     */
    public function getReservationRequestsSecondConfirmationReminderSendingTime(): ?int
    {
        return $this->reservationRequestsSecondConfirmationReminderSendingTime;
    }

    /**
     * @return int|null
     */
    public function getSpaceUsageReminderSendingHour(): ?int
    {
        return $this->spaceUsageReminderSendingHour;
    }

    /**
     * @return string|null
     */
    public function getExcludeSpaceIdsInitialValue(): ?string
    {
        return $this->excludeSpaceIdsInitialValue;
    }
}
