<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RentalSpaceRentalIntervalUpdateRequest extends FormRequest
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
            'ids' => 'required|array',
            'ids.*' => 'integer',
            'status' => 'nullable|string|in:active,archived',
            'applicability_periods' => 'nullable|array',
            'holiday_applicability_type' => 'nullable|integer',
            'tenancy_price' => 'nullable|integer|min:0',
            'per_person_price' => 'nullable|integer|min:0',
            'max_simultaneous_reservations' => 'required|integer|min:1',
            'max_simultaneous_people' => 'nullable|integer'
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
            'ids' => 'IDs',
            'status' => 'ステータス',
            'applicability_periods' => '適用期間',
            'holiday_applicability_type' => '休日の適用タイプ',
            'tenancy_price' => '借り賃',
            'per_person_price' => 'お一人様料金',
            'max_simultaneous_reservations' => '最大同時予約',
            'max_simultaneous_people' => '最大同時人数'
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
            'ids.required' => ':attributeは必須です。',
            'ids.array' => ':attributeには、配列を指定してください。',
            'ids.*.integer' => ':attributeには、整数を指定してください。',
            'applicability_periods.array' => ':attributeには、配列を指定してください。',
            'holiday_applicability_type.integer' => ':attributeには、整数を指定してください。',
            'tenancy_price.integer' => ':attributeには、整数を指定してください。',
            'tenancy_price.min' => ':attributeは:min文字以上で入力して下さい。',
            'per_person_price.integer' => ':attributeには、整数を指定してください。',
            'per_person_price.min' => ':attributeは:min文字以上で入力して下さい。',
            'max_simultaneous_reservations.required' => ':attributeは必須です。',
            'max_simultaneous_reservations.integer' => ':attributeには、整数を指定してください。',
            'max_simultaneous_reservations.min' => ':attributeは:min文字以上で入力して下さい。',
            'max_simultaneous_people.integer' => ':attributeには、整数を指定してください。',
            'status.string' => ':attributeには、文字を指定してください。',
            'status.in' => '選択された:attributeは、有効ではありません。:attributeは「active,archived」のいずれかの値です'
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
