<?php
namespace App\Bundle\SystemConfigBundle\Application;

use App\Bundle\SystemConfigBundle\Domain\Model\ISystemConfigRepository;
use App\Bundle\Common\Domain\Model\RecordNotFoundException;

final class SystemConfigGetApplicationService
{
    /**
     * @var ISystemConfigRepository $systemConfigRepository systemConfigRepository
     */
    private ISystemConfigRepository $systemConfigRepository;

    /**
     * @param \App\Bundle\SystemConfigBundle\Domain\Model\ISystemConfigRepository $systemConfigRepository systemConfigRepository
     */
    public function __construct(
        ISystemConfigRepository $systemConfigRepository
    ) {
        $this->systemConfigRepository = $systemConfigRepository;
    }

    /**
     * @param \App\Bundle\SystemConfigBundle\Application\SystemConfigGetCommand $command command
     * @return \App\Bundle\SystemConfigBundle\Application\SystemConfigGetResult
     */
    public function handle(SystemConfigGetCommand $command): SystemConfigGetResult
    {
        $systemConfig = $command->systemConfigId ? $this->systemConfigRepository->findByID(new SystemConfigId($command->systemConfigId)) : null;
        $systemConfig = $systemConfig ?: $this->systemConfigRepository->findByDefault();

        if (empty($systemConfig)) {
            throw new RecordNotFoundException('該当レコードが存在しません。');
        }

        return new SystemConfigGetResult(
            $systemConfig->getSystemConfigId()->getValue(),
            $systemConfig->getConciergeWorkingTimesConfiguration()->getMonday()->getStart(),
            $systemConfig->getConciergeWorkingTimesConfiguration()->getMonday()->getEnd(),
            $systemConfig->getConciergeWorkingTimesConfiguration()->getTuesday()->getStart(),
            $systemConfig->getConciergeWorkingTimesConfiguration()->getTuesday()->getEnd(),
            $systemConfig->getConciergeWorkingTimesConfiguration()->getWednesday()->getStart(),
            $systemConfig->getConciergeWorkingTimesConfiguration()->getWednesday()->getEnd(),
            $systemConfig->getConciergeWorkingTimesConfiguration()->getThursday()->getStart(),
            $systemConfig->getConciergeWorkingTimesConfiguration()->getThursday()->getEnd(),
            $systemConfig->getConciergeWorkingTimesConfiguration()->getFriday()->getStart(),
            $systemConfig->getConciergeWorkingTimesConfiguration()->getFriday()->getEnd(),
            $systemConfig->getConciergeWorkingTimesConfiguration()->getSaturday()->getStart(),
            $systemConfig->getConciergeWorkingTimesConfiguration()->getSaturday()->getEnd(),
            $systemConfig->getConciergeWorkingTimesConfiguration()->getSunday()->getStart(),
            $systemConfig->getConciergeWorkingTimesConfiguration()->getSunday()->getEnd(),
            $systemConfig->getReservationConfiguration()->getMaxRentalPlansCount(),
            $systemConfig->getReservationConfiguration()->getMaxRentalPlanIntervalsCount(),
            $systemConfig->getReservationConfiguration()->getBookingSystemInformationLink(),
            $systemConfig->getReservationConfiguration()->getHandlingFeePercentage(),
            $systemConfig->getReservationConfiguration()->getCcChargingFeePercentage(),
            $systemConfig->getReservationConfiguration()->getReservationRequestsConfirmationTimeout(),
            $systemConfig->getReservationConfiguration()->getReservationRequestsFirstConfirmationReminderSendingTime(),
            $systemConfig->getReservationConfiguration()->getReservationRequestsSecondConfirmationReminderSendingTime(),
            $systemConfig->getReservationConfiguration()->getSpaceUsageReminderSendingHour(),
            $systemConfig->getReservationConfiguration()->getExcludeSpaceIdsInitialValue(),
            $systemConfig->getTemporaryReservation()->getAllowedDaysAhead(),
            $systemConfig->getTemporaryReservation()->getDueDaysCancel(),
            $systemConfig->getTemporaryReservation()->getDueMonthsCancel(),
            $systemConfig->getTemporaryReservation()->getMonthsAsLongterm(),
            $systemConfig->getTemporaryReservation()->getDaysNotifyCancelation(),
            $systemConfig->getInquiryReminderForNotRespondYetHours(),
            $systemConfig->getTourRequestDenialPeriod(),
            $systemConfig->getFrontendTrackingCodeHtml(),
            $systemConfig->getBackendTrackingCodeHtml()
        );
    }
}
