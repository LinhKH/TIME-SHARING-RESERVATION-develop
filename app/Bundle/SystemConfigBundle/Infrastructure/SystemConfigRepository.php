<?php

namespace App\Bundle\SystemConfigBundle\Infrastructure;

use App\Bundle\SystemConfigBundle\Domain\Model\ConciergeWorkingTimesConfiguration;
use App\Bundle\SystemConfigBundle\Domain\Model\ISystemConfigRepository;
use App\Bundle\SystemConfigBundle\Domain\Model\ReservationConfiguration;
use App\Bundle\SystemConfigBundle\Domain\Model\SettingTimeRange;
use App\Bundle\SystemConfigBundle\Domain\Model\SystemConfig;
use App\Bundle\SystemConfigBundle\Domain\Model\SystemConfigId;
use App\Bundle\SystemConfigBundle\Domain\Model\TemporaryReservation;
use App\Models\SystemConfig as ModelSystemConfig;
use App\Models\SystemConfigEav as ModelSystemConfigEav;
use DateTime;
use Illuminate\Support\Facades\Date;

class SystemConfigRepository implements ISystemConfigRepository
{
    /**
     * @inheritDoc
     */
    public function findById(SystemConfigId $systemConfigId): ?SystemConfig
    {
        // TO DO
        return null;
    }

    /**
     * @inheritDoc
     */
    public function findByDefault(): ?SystemConfig
    {
        $systemConfig = ModelSystemConfig::find('default');

        if (empty($systemConfig)) {
            return null;
        }

        $systemConfigEavs = ModelSystemConfigEav::where('namespace', $systemConfig->id)->get()->toArray();
        $dataEav = [];
        foreach ($systemConfigEavs as $item) {
            $dataEav[$item['attribute']] = $item['value'];
        }

        $rangeTimeMonday = unserialize($dataEav['conciergeWorkingTimesConfiguration__monday_times']);
        $monday = new SettingTimeRange(
            (empty($rangeTimeMonday['start'])) ? null : new DateTime($rangeTimeMonday['start']),
            (empty($rangeTimeMonday['end'])) ? null : new DateTime($rangeTimeMonday['end'])
        );

        $rangeTimeTuesday = unserialize($dataEav['conciergeWorkingTimesConfiguration__tuesday_times']);
        $tuesday = new SettingTimeRange(
            (empty($rangeTimeTuesday['start'])) ? null : new DateTime($rangeTimeTuesday['start']),
            (empty($rangeTimeTuesday['end'])) ? null : new DateTime($rangeTimeTuesday['end'])
        );

        $rangeTimeWednesday = unserialize($dataEav['conciergeWorkingTimesConfiguration__wednesday_times']);
        $wednesday = new SettingTimeRange(
            (empty($rangeTimeWednesday['start'])) ? null : new DateTime($rangeTimeWednesday['start']),
            (empty($rangeTimeWednesday['end'])) ? null : new DateTime($rangeTimeWednesday['end'])
        );

        $rangeTimeThursday = unserialize($dataEav['conciergeWorkingTimesConfiguration__thursday_times']);
        $thursday = new SettingTimeRange(
            (empty($rangeTimeThursday['start'])) ? null : new DateTime($rangeTimeThursday['start']),
            (empty($rangeTimeThursday['end'])) ? null : new DateTime($rangeTimeThursday['end'])
        );

        $rangeTimeFriday = unserialize($dataEav['conciergeWorkingTimesConfiguration__friday_times']);
        $friday = new SettingTimeRange(
            (empty($rangeTimeFriday['start'])) ? null : new DateTime($rangeTimeFriday['start']),
            (empty($rangeTimeFriday['end'])) ? null : new DateTime($rangeTimeFriday['end'])
        );

        $rangeTimeSaturday = unserialize($dataEav['conciergeWorkingTimesConfiguration__saturday_times']);
        $saturday = new SettingTimeRange(
            (empty($rangeTimeSaturday['start'])) ? null : new DateTime($rangeTimeSaturday['start']),
            (empty($rangeTimeSaturday['end'])) ? null : new DateTime($rangeTimeSaturday['end'])
        );

        $rangeTimeSunday = unserialize($dataEav['conciergeWorkingTimesConfiguration__sunday_times']);
        $sunday = new SettingTimeRange(
            (empty($rangeTimeSunday['start'])) ? null : new DateTime($rangeTimeSunday['start']),
            (empty($rangeTimeSunday['end'])) ? null : new DateTime($rangeTimeSunday['end'])
        );

        return new SystemConfig(
            new SystemConfigId($systemConfig->id),
            new ReservationConfiguration(
                $dataEav['reservationConfiguration__max_rental_plans_count'],
                $dataEav['reservationConfiguration__max_rental_plan_intervals_count'],
                $dataEav['reservationConfiguration__booking_system_information_link'],
                $dataEav['reservationConfiguration__handling_fee_percentage'],
                $dataEav['reservationConfiguration__cc_charging_fee_percentage'],
                $dataEav['reservationConfiguration__reservation_requests_confirmation_timeout'],
                $dataEav['reservationConfiguration__reservation_requests_first_confirmation_reminder_sending_time'],
                $dataEav['reservationConfiguration__reservation_requests_second_confirmation_reminder_sending_time'],
                $dataEav['reservationConfiguration__space_usage_reminder_sending_hour'],
                $dataEav['reservationConfiguration__exclude_space_ids_initial_value']
            ),
            new ConciergeWorkingTimesConfiguration(
                $monday,
                $tuesday,
                $wednesday,
                $thursday,
                $friday,
                $saturday,
                $sunday
            ),
            new TemporaryReservation(
                $dataEav['temporaryReservation__allowed_days_ahead'],
                $dataEav['temporaryReservation__due_days_cancel'],
                $dataEav['temporaryReservation__due_months_cancel'],
                $dataEav['temporaryReservation__months_as_longterm'],
                $dataEav['temporaryReservation__days_notify_cancelation']
            ),
            $dataEav['inquiry_reminder_for_not_respond_yet_hours'],
            $dataEav['tour_request_denial_period'],
            $dataEav['frontend_tracking_code_html'],
            $dataEav['backend_tracking_code_html']
        );
    }

    /**
     * @inheritDoc
     */
    public function update(SystemConfig $systemConfig): SystemConfigId
    {

        ModelSystemConfigEav::where('namespace', $systemConfig->getSystemConfigId()->getValue())->delete();

        $dataEav = [
            "reservationConfiguration__max_rental_plans_count" => $systemConfig->getReservationConfiguration()->getMaxRentalPlansCount(),
            "reservationConfiguration__max_rental_plan_intervals_count" => $systemConfig->getReservationConfiguration()->getMaxRentalPlanIntervalsCount(),
            "reservationConfiguration__booking_system_information_link" => $systemConfig->getReservationConfiguration()->getBookingSystemInformationLink(),
            "reservationConfiguration__handling_fee_percentage" => $systemConfig->getReservationConfiguration()->getHandlingFeePercentage(),
            "reservationConfiguration__cc_charging_fee_percentage" => $systemConfig->getReservationConfiguration()->getCcChargingFeePercentage(),
            "reservationConfiguration__reservation_requests_confirmation_timeout" => $systemConfig->getReservationConfiguration()->getReservationRequestsConfirmationTimeout(),
            "reservationConfiguration__reservation_requests_first_confirmation_reminder_sending_time" => $systemConfig->getReservationConfiguration()->getReservationRequestsFirstConfirmationReminderSendingTime(),
            "reservationConfiguration__reservation_requests_second_confirmation_reminder_sending_time" => $systemConfig->getReservationConfiguration()->getReservationRequestsSecondConfirmationReminderSendingTime(),
            "reservationConfiguration__space_usage_reminder_sending_hour" => $systemConfig->getReservationConfiguration()->getSpaceUsageReminderSendingHour(),
            "reservationConfiguration__exclude_space_ids_initial_value" => $systemConfig->getReservationConfiguration()->getExcludeSpaceIdsInitialValue(),
            "conciergeWorkingTimesConfiguration__monday_times" => serialize(array(
                "start" => $systemConfig->getConciergeWorkingTimesConfiguration()->getMonday()->getStart(),
                "end" => $systemConfig->getConciergeWorkingTimesConfiguration()->getMonday()->getEnd(),
            )),
            "conciergeWorkingTimesConfiguration__tuesday_times" => serialize(array(
                "start" => $systemConfig->getConciergeWorkingTimesConfiguration()->getTuesday()->getStart(),
                "end" => $systemConfig->getConciergeWorkingTimesConfiguration()->getTuesday()->getEnd(),
            )),
            "conciergeWorkingTimesConfiguration__wednesday_times" => serialize(array(
                "start" => $systemConfig->getConciergeWorkingTimesConfiguration()->getWednesday()->getStart(),
                "end" => $systemConfig->getConciergeWorkingTimesConfiguration()->getWednesday()->getEnd(),
            )),
            "conciergeWorkingTimesConfiguration__thursday_times" => serialize(array(
                "start" => $systemConfig->getConciergeWorkingTimesConfiguration()->getThursday()->getStart(),
                "end" => $systemConfig->getConciergeWorkingTimesConfiguration()->getThursday()->getEnd(),
            )),
            "conciergeWorkingTimesConfiguration__friday_times" => serialize(array(
                "start" => $systemConfig->getConciergeWorkingTimesConfiguration()->getFriday()->getStart(),
                "end" => $systemConfig->getConciergeWorkingTimesConfiguration()->getFriday()->getEnd(),
            )),
            "conciergeWorkingTimesConfiguration__saturday_times" => serialize(array(
                "start" => $systemConfig->getConciergeWorkingTimesConfiguration()->getSaturday()->getStart(),
                "end" => $systemConfig->getConciergeWorkingTimesConfiguration()->getSaturday()->getEnd(),
            )),
            "conciergeWorkingTimesConfiguration__sunday_times" => serialize(array(
                "start" => $systemConfig->getConciergeWorkingTimesConfiguration()->getSunday()->getStart(),
                "end" => $systemConfig->getConciergeWorkingTimesConfiguration()->getSunday()->getEnd(),
            )),
            "temporaryReservation__allowed_days_ahead" => $systemConfig->getTemporaryReservation()->getAllowedDaysAhead(),
            "temporaryReservation__due_days_cancel" => $systemConfig->getTemporaryReservation()->getDueDaysCancel(),
            "temporaryReservation__due_months_cancel" => $systemConfig->getTemporaryReservation()->getDueMonthsCancel(),
            "temporaryReservation__months_as_longterm" => $systemConfig->getTemporaryReservation()->getMonthsAsLongterm(),
            "temporaryReservation__days_notify_cancelation" => $systemConfig->getTemporaryReservation()->getDaysNotifyCancelation(),
            "inquiry_reminder_for_not_respond_yet_hours" => $systemConfig->getInquiryReminderForNotRespondYetHours(),
            "tour_request_denial_period" => $systemConfig->getTourRequestDenialPeriod(),
            "frontend_tracking_code_html" => $systemConfig->getFrontendTrackingCodeHtml(),
            "backend_tracking_code_html" => $systemConfig->getBackendTrackingCodeHtml()
        ];

        foreach ($dataEav as $key => $value) {
            $systemConfigEav = ModelSystemConfigEav::create([
                'namespace' => $systemConfig->getSystemConfigId()->getValue(),
                'attribute' => $key,
                'value' => $value,
                'type' => 's'
            ]);
            $systemConfigEav->save();
        }

        return new SystemConfigId($systemConfig->getSystemConfigId()->getValue());
    }

}
