<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RentalSpaceBookingSystemAdvancedRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
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
            'enable_last_minute_discount' => 'integer|between:1,2',
            'last_minute_book_discount_days_before_count' => 'integer|min:0',
            'last_minute_book_discount_percentage' => 'numeric|between:0,99.99'
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
            'enable_last_minute_discount' => '直前割引',
            'last_minute_book_discount_days_before_count' => '割引を開始',
            'last_minute_book_discount_percentage' => '合計金額からの割引率'
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
            'enable_last_minute_discount.integer' => ':attributeには、整数を指定してください。',
            'last_minute_book_discount_days_before_count.integer' => ':attributeには、整数を指定してください。',
            'last_minute_book_discount_percentage.numeric' => ':attributeは:max文字以内で入力してください。',
            'last_minute_book_discount_percentage.between' => ':attributeには、:minから、:maxまでの数字を指定してください。',
            'enable_last_minute_discount.between' => '選択された:attributeは、有効ではありません。',
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
