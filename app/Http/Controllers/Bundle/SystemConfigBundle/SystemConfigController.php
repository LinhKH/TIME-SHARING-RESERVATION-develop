<?php

namespace App\Http\Controllers\Bundle\SystemConfigBundle;

use App\Bundle\Common\Domain\Model\RecordNotFoundException;
use App\Bundle\Common\Domain\Model\TransactionException;
use App\Bundle\SystemConfigBundle\Application\SystemConfigGetApplicationService;
use App\Bundle\SystemConfigBundle\Application\SystemConfigGetCommand;
use App\Bundle\SystemConfigBundle\Application\SystemConfigPutApplicationService;
use App\Bundle\SystemConfigBundle\Application\SystemConfigPutCommand;
use App\Bundle\SystemConfigBundle\Infrastructure\SystemConfigRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\SystemConfigRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SystemConfigController extends Controller
{
    /**
     * @param SystemConfigRequest $request
     * @return JsonResponse
     * @throws TransactionException
     */
    public function updateAction(SystemConfigRequest $request) {
        $systemConfigRepository = new SystemConfigRepository();

        $applicationService = new SystemConfigPutApplicationService(
            $systemConfigRepository
        );

        $command = new SystemConfigPutCommand(
            $request->id,
            $request->start_monday,
            $request->end_monday,
            $request->start_tuesday,
            $request->end_tuesday,
            $request->start_wednesday,
            $request->end_wednesday,
            $request->start_thursday,
            $request->end_thursday,
            $request->start_friday,
            $request->end_friday,
            $request->start_saturday,
            $request->end_saturday,
            $request->start_sunday,
            $request->end_sunday,
            $request->max_rental_plans_count,
            $request->max_rental_plan_intervals_count,
            $request->booking_system_information_link,
            $request->handling_fee_percentage,
            $request->cc_charging_fee_percentage,
            $request->reservation_requests_confirmation_timeout,
            $request->reservation_requests_first_confirmation_reminder_sending_time,
            $request->reservation_requests_second_confirmation_reminder_sending_time,
            $request->space_usage_reminder_sending_hour,
            $request->exclude_space_ids_initial_value,
            $request->allowed_days_ahead,
            $request->due_days_cancel,
            $request->due_months_cancel,
            $request->months_as_longterm,
            $request->days_notify_cancelation,
            $request->inquiry_reminder_for_not_respond_yet_hours,
            $request->tour_request_denial_period,
            $request->frontend_tracking_code_html,
            $request->backend_tracking_code_html
        );

        $result = $applicationService->handle($command);

        return response()->json(['system_config_id' => $result->systemConfigId], 200);
    }

    /**
     * @return JsonResponse
     * @throws RecordNotFoundException
     */
    public function viewAction() {
        $systemConfigRepository = new SystemConfigRepository();

        $applicationService = new SystemConfigGetApplicationService(
            $systemConfigRepository
        );

        $command = new SystemConfigGetCommand(null);

        $result = $applicationService->handle($command);

        return response()->json([
            'id' => $result->systemConfigId,
            'max_rental_plans_count' => $result->maxRentalPlansCount,
            'max_rental_plan_intervals_count' => $result->maxRentalPlanIntervalsCount,
            'booking_system_information_link' => $result->bookingSystemInformationLink,
            'handling_fee_percentage' => $result->handlingFeePercentage,
            'cc_charging_fee_percentage' => $result->ccChargingFeePercentage,
            'reservation_requests_confirmation_timeout' => $result->reservationRequestsConfirmationTimeout,
            'reservation_requests_first_confirmation_reminder_sending_time' => $result->reservationRequestsFirstConfirmationReminderSendingTime,
            'reservation_requests_second_confirmation_reminder_sending_time' => $result->reservationRequestsSecondConfirmationReminderSendingTime,
            'space_usage_reminder_sending_hour' => $result->spaceUsageReminderSendingHour,
            'exclude_space_ids_initial_value' => $result->excludeSpaceIdsInitialValue,
            'inquiry_reminder_for_not_respond_yet_hours' => $result->inquiryReminderForNotRespondYetHours,
            'tour_request_denial_period' => $result->tourRequestDenialPeriod,
            'frontend_tracking_code_html' => $result->frontendTrackingCodeHtml,
            'backend_tracking_code_html' => $result->backendTrackingCodeHtml,
            'start_monday' => $result->startMonday,
            'end_monday' => $result->endMonday,
            'start_tuesday' => $result->startTuesday,
            'end_tuesday' => $result->endTuesday,
            'start_wednesday' => $result->startWednesday,
            'end_wednesday' => $result->endWednesday,
            'start_thursday' => $result->startThursday,
            'end_thursday' => $result->endThursday,
            'start_friday' => $result->startFriday,
            'end_friday' => $result->endFriday,
            'start_saturday' => $result->startSaturday,
            'end_saturday' => $result->endSaturday,
            'start_sunday' => $result->startSunday,
            'end_sunday' => $result->endSunday,
            'allowed_days_ahead' => $result->allowedDaysAhead,
            'due_days_cancel' => $result->dueDaysCancel,
            'months_as_longterm' => $result->monthsAsLongterm,
            'due_months_cancel' => $result->dueMonthsCancel,
            'days_notify_cancelation' => $result->daysNotifyCancelation
        ], 200);
    }
}
