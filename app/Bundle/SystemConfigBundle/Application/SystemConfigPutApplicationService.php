<?php
namespace App\Bundle\SystemConfigBundle\Application;

use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\SystemConfigBundle\Domain\Model\ConciergeWorkingTimesConfiguration;
use App\Bundle\SystemConfigBundle\Domain\Model\ISystemConfigRepository;
use App\Bundle\SystemConfigBundle\Domain\Model\ReservationConfiguration;
use App\Bundle\SystemConfigBundle\Domain\Model\SettingTimeRange;
use App\Bundle\SystemConfigBundle\Domain\Model\SystemConfig;
use App\Bundle\SystemConfigBundle\Domain\Model\SystemConfigId;
use App\Bundle\SystemConfigBundle\Domain\Model\TemporaryReservation;
use DateTime;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

final class SystemConfigPutApplicationService
{
    private ISystemConfigRepository $systemConfigRepository;

    /**
     * @param ISystemConfigRepository $systemConfigRepository systemConfigRepository
     */
    public function __construct(
        ISystemConfigRepository $systemConfigRepository
    ) {
        $this->systemConfigRepository = $systemConfigRepository;
    }

    /**
     * @param SystemConfigPutCommand $command
     * @return SystemConfigPutResult
     * @throws TransactionException
     * @throws Exception
     */
    public function handle(SystemConfigPutCommand $command): SystemConfigPutResult
    {

        $systemConfig = new SystemConfig(
            new SystemConfigId(
                $command->systemConfigId
            ),
            new ReservationConfiguration(
                $command->maxRentalPlansCount,
                $command->maxRentalPlanIntervalsCount,
                $command->bookingSystemInformationLink,
                $command->handlingFeePercentage,
                $command->ccChargingFeePercentage,
                $command->reservationRequestsConfirmationTimeout,
                $command->reservationRequestsFirstConfirmationReminderSendingTime,
                $command->reservationRequestsSecondConfirmationReminderSendingTime,
                $command->spaceUsageReminderSendingHour,
                $command->excludeSpaceIdsInitialValue
            ),
            new ConciergeWorkingTimesConfiguration(
                new SettingTimeRange(
                    ($command->startMonday) ? new DateTime($command->startMonday) : null,
                    ($command->endMonday) ? new DateTime($command->endMonday) : null
                ),
                new SettingTimeRange(
                    ($command->startTuesday) ? new DateTime($command->startTuesday) : null,
                    ($command->endTuesday) ? new DateTime($command->endTuesday) : null,
                ),
                new SettingTimeRange(
                    ($command->startWednesday) ? new DateTime($command->startWednesday) : null,
                    ($command->endWednesday) ? new DateTime($command->endWednesday) : null,
                ),
                new SettingTimeRange(
                    ($command->startThursday) ? new DateTime($command->startThursday) : null,
                    ($command->endThursday) ? new DateTime($command->endThursday) : null,
                ),
                new SettingTimeRange(
                    ($command->startFriday) ? new DateTime($command->startFriday) : null,
                    ($command->endFriday) ? new DateTime($command->endFriday) : null,
                ),
                new SettingTimeRange(
                    ($command->startSaturday) ? new DateTime($command->startSaturday) : null,
                    ($command->endSaturday) ? new DateTime($command->endSaturday) : null,
                ),
                new SettingTimeRange(
                    ($command->startSunday) ? new DateTime($command->startSunday) : null,
                    ($command->endSunday) ? new DateTime($command->endSunday) : null,
                )
            ),
            new TemporaryReservation(
                $command->allowedDaysAhead,
                $command->dueDaysCancel,
                $command->dueMonthsCancel,
                $command->monthsAsLongterm,
                $command->daysNotifyCancelation
            ),
            $command->inquiryReminderForNotRespondYetHours,
            $command->tourRequestDenialPeriod,
            $command->frontendTrackingCodeHtml,
            $command->backendTrackingCodeHtml
        );

        DB::beginTransaction();
        try {
            $systemConfigId = $this->systemConfigRepository->update($systemConfig);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e);
             throw new TransactionException('更新できませんでした');
        }

        return new SystemConfigPutResult(
            $systemConfigId->getValue()
        );
    }
}
