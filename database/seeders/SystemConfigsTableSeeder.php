<?php

namespace Database\Seeders;

use App\Models\SystemConfig;
use App\Models\SystemConfigEav;
use Illuminate\Database\Seeder;

class SystemConfigsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SystemConfig::create(['id' => 'default']);

        $defaults = [
            [
                'id' => 1,
                'namespace' => 'default',
                'attribute' => 'backend_tracking_code_html',
                'value' => '',
                'type' => 's'
            ],
            [
                'id' => 2,
                'namespace' => 'default',
                'attribute' => 'conciergeWorkingTimesConfiguration__friday_times',
                'value' => 'a:2:{s:5:"start";s:5:"10:00";s:3:"end";s:5:"19:00";}',
                'type' => 's'
            ],
            [
                'id' => 3,
                'namespace' => 'default',
                'attribute' => 'conciergeWorkingTimesConfiguration__monday_times',
                'value' => 'a:2:{s:5:"start";s:5:"10:00";s:3:"end";s:5:"19:00";}',
                'type' => 's'
            ],
            [
                'id' => 4,
                'namespace' => 'default',
                'attribute' => 'conciergeWorkingTimesConfiguration__saturday_times',
                'value' => 'a:2:{s:5:"start";s:5:"10:00";s:3:"end";s:5:"19:00";}',
                'type' => 's'
            ],
            [
                'id' => 5,
                'namespace' => 'default',
                'attribute' => 'conciergeWorkingTimesConfiguration__sunday_times',
                'value' => 'a:2:{s:5:"start";s:5:"10:00";s:3:"end";s:5:"19:00";}',
                'type' => 's'
            ],
            [
                'id' => 6,
                'namespace' => 'default',
                'attribute' => 'conciergeWorkingTimesConfiguration__thursday_times',
                'value' => 'a:2:{s:5:"start";s:5:"10:00";s:3:"end";s:5:"19:00";}',
                'type' => 's'
            ],
            [
                'id' => 7,
                'namespace' => 'default',
                'attribute' => 'conciergeWorkingTimesConfiguration__tuesday_times',
                'value' => 'a:2:{s:5:"start";s:5:"10:00";s:3:"end";s:5:"19:00";}',
                'type' => 's'
            ],
            [
                'id' => 8,
                'namespace' => 'default',
                'attribute' => 'conciergeWorkingTimesConfiguration__wednesday_times',
                'value' => 'a:2:{s:5:"start";s:5:"10:00";s:3:"end";s:5:"19:00";}',
                'type' => 's'
            ],
            [
                'id' => 9,
                'namespace' => 'default',
                'attribute' => 'frontend_tracking_code_html',
                'value' => '',
                'type' => 's'
            ],
            [
                'id' => 10,
                'namespace' => 'default',
                'attribute' => 'inquiry_reminder_for_not_respond_yet_hours',
                'value' => '36',
                'type' => 's'
            ],
            [
                'id' => 11,
                'namespace' => 'default',
                'attribute' => 'reservationConfiguration__booking_system_information_link',
                'value' => 'https://s3-ap-northeast-1.amazonaws.com/supenavi/promotional/supenavi-space-reserve-brochure.pdf',
                'type' => 's'
            ],
            [
                'id' => 12,
                'namespace' => 'default',
                'attribute' => 'reservationConfiguration__cc_charging_fee_percentage',
                'value' => '0',
                'type' => 'f'
            ],
            [
                'id' => 13,
                'namespace' => 'default',
                'attribute' => 'reservationConfiguration__max_rental_plans_count',
                'value' => '5',
                'type' => 'i'
            ],
            [
                'id' => 14,
                'namespace' => 'default',
                'attribute' => 'reservationConfiguration__max_rental_plan_intervals_count',
                'value' => '100',
                'type' => 'i'
            ],
            [
                'id' => 15,
                'namespace' => 'default',
                'attribute' => 'reservationConfiguration__handling_fee_percentage',
                'value' => '0',
                'type' => 'i'
            ],
            [
                'id' => 16,
                'namespace' => 'default',
                'attribute' => 'reservationConfiguration__reservation_requests_confirmation_timeout',
                'value' => '720',
                'type' => 'i'
            ],
            [
                'id' => 17,
                'namespace' => 'default',
                'attribute' => 'reservationConfiguration__reservation_requests_first_confirmation_reminder_sending_time',
                'value' => '9',
                'type' => 'i'
            ],
            [
                'id' => 18,
                'namespace' => 'default',
                'attribute' => 'reservationConfiguration__reservation_requests_second_confirmation_reminder_sending_time',
                'value' => '3',
                'type' => 'i'
            ],
            [
                'id' => 19,
                'namespace' => 'default',
                'attribute' => 'reservationConfiguration__space_usage_reminder_sending_hour',
                'value' => '23',
                'type' => 'i'
            ],
            [
                'id' => 20,
                'namespace' => 'default',
                'attribute' => 'reservationConfiguration__exclude_space_ids_initial_value',
                'value' => '3',
                'type' => 's'
            ],
            [
                'id' => 21,
                'namespace' => 'default',
                'attribute' => 'reservationConfiguration__exclude_space_ids_initial_value',
                'value' => '3',
                'type' => 's'
            ],
            [
                'id' => 26,
                'namespace' => 'default',
                'attribute' => 'tour_request_denial_period',
                'value' => '720',
                'type' => 's'
            ],
            [
                'id' => 22,
                'namespace' => 'default',
                'attribute' => 'inquiry_reminder_for_not_responde_yet_hours',
                'value' => '36',
                'type' => 's'
            ],
            [
                'id' => 23,
                'namespace' => 'default',
                'attribute' => 'temporaryReservation__allowed_days_ahead',
                'value' => '8',
                'type' => 'i'
            ],
            [
                'id' => 24,
                'namespace' => 'default',
                'attribute' => 'temporaryReservation__due_days_cancel',
                'value' => '7',
                'type' => 'i'
            ],
            [
                'id' => 25,
                'namespace' => 'default',
                'attribute' => 'temporaryReservation__days_notify_cancelation',
                'value' => '1',
                'type' => 'i'
            ],
            [
                'id' => 27,
                'namespace' => 'default',
                'attribute' => 'temporaryReservation__months_as_longterm',
                'value' => '1',
                'type' => 'i'
            ],
            [
                'id' => 28,
                'namespace' => 'default',
                'attribute' => 'temporaryReservation__due_months_cancel',
                'value' => '1',
                'type' => 'i'
            ],
            [
                'id' => 29,
                'namespace' => 'default',
                'attribute' => 'frontend_tracking_code_html',
                'value' => 'aaaaaaaaa',
                'type' => 'i'
            ],
            [
                'id' => 30,
                'namespace' => 'default',
                'attribute' => 'backend_tracking_code_html',
                'value' => 'aaaaaaa',
                'type' => 'i'
            ]
        ];

        foreach ($defaults as $v) {
            SystemConfigEav::create($v);
        }
    }

}
