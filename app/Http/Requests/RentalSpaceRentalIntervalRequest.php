<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RentalSpaceRentalIntervalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'applicability_periods' => 'required|array',
            'holiday_applicability_type' => 'required|integer',
            'interval_multi' => 'required|integer',
            'start_time_formatted' => 'required|string',
            'end_time_formatted' => 'required|string',
            'tenancy_price' => 'nullable|integer|min:0',
            'per_person_price' => 'nullable|integer|min:0',
            'max_simultaneous_reservations' => 'required|integer|min:1',
            'max_simultaneous_people'  => 'nullable|integer'
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
            'applicability_periods' => '適用期間',
            'holiday_applicability_type' => '休日の適用タイプ',
            'interval_multi' => '予約枠ごとの時間設定',
            'start_time_formatted' => 'フォーマットされた開始時間',
            'end_time_formatted' => 'フォーマットされた終了時間',
            'tenancy_price' => '借り賃',
            'per_person_price' => 'お一人様料金',
            'max_simultaneous_reservations' => '最大同時予約',
            'max_simultaneous_people'  => '最大同時人数'
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
            'applicability_periods.required' => ':attributeは必須です。',
            'applicability_periods.array' => ':attributeには、配列を指定してください。',
            'holiday_applicability_type.required' => ':attributeは必須です。',
            'holiday_applicability_type.integer' => ':attributeには、整数を指定してください。',
            'interval_multi.required' => ':attributeは必須です。',
            'interval_multi.integer' => ':attributeには、整数を指定してください。',
            'start_time_formatted.required' => ':attributeは必須です。',
            'start_time_formatted.string' => ':attributeは:min文字以上で入力して下さい。',
            'end_time_formatted.required' => ':attributeは必須です。',
            'end_time_formatted.string' => ':attributeは:min文字以上で入力して下さい。',
            'tenancy_price.integer' => ':attributeには、整数を指定してください。',
            'tenancy_price.min' => ':attributeは:min文字以上で入力して下さい。',
            'per_person_price.integer' => ':attributeには、整数を指定してください。',
            'per_person_price.min' => ':attributeは:min文字以上で入力して下さい。',
            'max_simultaneous_reservations.required' => ':attributeは必須です。',
            'max_simultaneous_reservations.integer' => ':attributeには、整数を指定してください。',
            'max_simultaneous_reservations.min' => ':attributeは:min文字以上で入力して下さい。',
            'max_simultaneous_people.integer' => ':attributeには、整数を指定してください。',
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
