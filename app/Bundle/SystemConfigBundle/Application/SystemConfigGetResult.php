<?php
namespace App\Bundle\SystemConfigBundle\Application;

final class SystemConfigGetResult
{
    public string $systemConfigId;
    public ?string $startMonday;
    public ?string $endMonday;
    public ?string $startTuesday;
    public ?string $endTuesday;
    public ?string $startWednesday;
    public ?string $endWednesday;
    public ?string $startThursday;
    public ?string $endThursday;
    public ?string $startFriday;
    public ?string $endFriday;
    public ?string $startSaturday;
    public ?string $endSaturday;
    public ?string $startSunday;
    public ?string $endSunday;
    public ?int $maxRentalPlansCount;
    public ?int $maxRentalPlanIntervalsCount;
    public ?string $bookingSystemInformationLink;
    public ?int $handlingFeePercentage;
    public ?int $ccChargingFeePercentage;
    public ?int $reservationRequestsConfirmationTimeout;
    public ?int $reservationRequestsFirstConfirmationReminderSendingTime;
    public ?int $reservationRequestsSecondConfirmationReminderSendingTime;
    public ?int $spaceUsageReminderSendingHour;
    public ?string $excludeSpaceIdsInitialValue;
    public int $allowedDaysAhead;
    public int $dueDaysCancel;
    public int $dueMonthsCancel;
    public int $monthsAsLongterm;
    public int $daysNotifyCancelation;
    public int $inquiryReminderForNotRespondYetHours;
    public int $tourRequestDenialPeriod;
    public ?string $frontendTrackingCodeHtml;
    public ?string $backendTrackingCodeHtml;


    public function __construct(
        string $systemConfigId,
        ?string $startMonday,
        ?string $endMonday,
        ?string $startTuesday,
        ?string $endTuesday,
        ?string $startWednesday,
        ?string $endWednesday,
        ?string $startThursday,
        ?string $endThursday,
        ?string $startFriday,
        ?string $endFriday,
        ?string $startSaturday,
        ?string $endSaturday,
        ?string $startSunday,
        ?string $endSunday,
        ?int $maxRentalPlansCount,
        ?int $maxRentalPlanIntervalsCount,
        ?string $bookingSystemInformationLink,
        ?int $handlingFeePercentage,
        ?int $ccChargingFeePercentage,
        ?int  $reservationRequestsConfirmationTimeout,
        ?int $reservationRequestsFirstConfirmationReminderSendingTime,
        ?int $reservationRequestsSecondConfirmationReminderSendingTime,
        ?int $spaceUsageReminderSendingHour,
        ?string $excludeSpaceIdsInitialValue,
        int $allowedDaysAhead,
        int $dueDaysCancel,
        int $dueMonthsCancel,
        int $monthsAsLongterm,
        int $daysNotifyCancelation,
        int $inquiryReminderForNotRespondYetHours,
        int $tourRequestDenialPeriod,
        ?string $frontendTrackingCodeHtml,
        ?string $backendTrackingCodeHtml
    ) {
        $this->systemConfigId = $systemConfigId;
        $this->startMonday = $startMonday;
        $this->endMonday = $endMonday;
        $this->startTuesday = $startTuesday;
        $this->endTuesday = $endTuesday;
        $this->startWednesday = $startWednesday;
        $this->endWednesday = $endWednesday;
        $this->startThursday = $startThursday;
        $this->endThursday = $endThursday;
        $this->startFriday = $startFriday;
        $this->endFriday = $endFriday;
        $this->startSaturday = $startSaturday;
        $this->endSaturday = $endSaturday;
        $this->startSunday = $startSunday;
        $this->endSunday = $endSunday;
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
        $this->allowedDaysAhead = $allowedDaysAhead;
        $this->dueDaysCancel = $dueDaysCancel;
        $this->dueMonthsCancel = $dueMonthsCancel;
        $this->monthsAsLongterm = $monthsAsLongterm;
        $this->daysNotifyCancelation = $daysNotifyCancelation;
        $this->inquiryReminderForNotRespondYetHours = $inquiryReminderForNotRespondYetHours;
        $this->tourRequestDenialPeriod = $tourRequestDenialPeriod;
        $this->frontendTrackingCodeHtml = $frontendTrackingCodeHtml;
        $this->backendTrackingCodeHtml = $backendTrackingCodeHtml;
    }
}
