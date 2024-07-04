<?php


namespace App\Http\Requests;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SystemConfigRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @param Request $request
     * @return array
     */
    public function rules(Request $request): array
    {
        return [
            'max_rental_plans_count' => 'required|numeric|gte:0',
            'max_rental_plan_intervals_count' => 'required|numeric|gte:0',
            'booking_system_information_link' => 'url',
            'handling_fee_percentage' => 'numeric|between:0,100',
            'cc_charging_fee_percentage' => 'numeric|between:0,100',
            'reservation_requests_confirmation_timeout' => 'numeric|gte:0',
            'reservation_requests_first_confirmation_reminder_sending_time' => 'integer|min:0',
            'reservation_requests_second_confirmation_reminder_sending_time' => 'integer|min:0',
            'space_usage_reminder_sending_hour' => 'integer|between:0,23',
            'inquiry_reminder_for_not_respond_yet_hours' => 'integer|min:1',
            'tour_request_denial_period' => 'integer|min:1',
            'allowed_days_ahead' => 'integer',
            'due_days_cancel' => 'integer',
            'months_as_longterm' => 'integer',
            'due_months_cancel' => 'integer',
            'days_notify_cancelation' => 'integer'
        ];
    }

    /**
     * Determine attributes.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'max_rental_plans_count' => '料金プラン数の上限',
            'max_rental_plan_intervals_count' => 'レンタル時間数の上限',
            'booking_system_information_link' => '予約システム詳細リンク',
            'handling_fee_percentage' => '成約手数料パーセント',
            'cc_charging_fee_percentage' => 'クレカ決済手数料パーセント',
            'reservation_requests_confirmation_timeout' => 'リクエスト予約承認期限',
            'reservation_requests_first_confirmation_reminder_sending_time' => 'リクエスト予約承認アラートメール1',
            'reservation_requests_second_confirmation_reminder_sending_time' => 'リクエスト予約承認アラートメール2',
            'space_usage_reminder_sending_hour' => '予約リマインドメール（前日）',
            'inquiry_reminder_for_not_respond_yet_hours' => 'リマインドメール送信時間',
            'tour_request_denial_period' => '見学リクエストの自動否認時間',
            'allowed_days_ahead' => '仮予約期限',
            'due_days_cancel' => 'キャンセル期限',
            'months_as_longterm' => '長期仮予約',
            'due_months_cancel' => 'キャンセル月数',
            'days_notify_cancelation' => 'キャンセル通知日数'
        ];
    }

    /**
     * Determine message.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'max_rental_plans_count.required' => ':attributeは必須です。',
            'max_rental_plans_count.numeric' => ':attributeには、数字を指定してください。',
            'max_rental_plan_intervals_count.required' => ':attributeは必須です。',
            'max_rental_plan_intervals_count.numeric' => ':attributeには、数字を指定してください。',
            'booking_system_information_link.url' => ':attributeは、有効なURL形式で指定してください。',
            'handling_fee_percentage.between' => ':attributeには、:minから、:maxまでの数字を指定してください。',
            'handling_fee_percentage.numeric' => ':attributeには、数字を指定してください。',
            'cc_charging_fee_percentage.between' => ':attributeには、:minから、:maxまでの数字を指定してください。',
            'cc_charging_fee_percentage.numeric' => ':attributeには、数字を指定してください。',
            'reservation_requests_confirmation_timeout.numeric' => ':attributeには、数字を指定してください。',
            'reservation_requests_first_confirmation_reminder_sending_time.integer' => ':attributeには、整数を指定してください。',
            'reservation_requests_second_confirmation_reminder_sending_time.integer' => ':attributeには、整数を指定してください。',
            'space_usage_reminder_sending_hour.between' => ':attributeには、:minから、:maxまでの数字を指定してください。',
            'space_usage_reminder_sending_hour.numeric' => ':attributeには、数字を指定してください。',
            'inquiry_reminder_for_not_respond_yet_hours.integer' => ':attributeには、整数を指定してください。',
            'inquiry_reminder_for_not_respond_yet_hours.min' => ':attributeは:min文字以上で入力して下さい。',
            'tour_request_denial_period.integer' => ':attributeには、整数を指定してください。',
            'tour_request_denial_period.min' => ':attributeは:min文字以上で入力して下さい。',
            'allowed_days_ahead.integer' => ':attributeには、整数を指定してください。',
            'due_days_cancel.integer' => ':attributeには、整数を指定してください。',
            'months_as_longterm.integer' => ':attributeには、整数を指定してください。',
            'due_months_cancel.integer' => ':attributeには、整数を指定してください。',
            'days_notify_cancelation.integer' => ':attributeには、整数を指定してください。',
        ];
    }

    /**
     * Validate fail
     *
     * @param Validator $validator
     */
    public function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->getMessages();
        $data = [];
        foreach ($errors as $key => $messages) {
            $data[] = [
                'key' => $key,
                'messages' => $messages,
            ];
        }
        $response = ['data' => $data, 'code' => 422];

        throw new HttpResponseException(response()->json($response, Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
