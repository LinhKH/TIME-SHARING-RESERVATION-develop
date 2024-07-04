<?php

namespace App\Http\Requests;

use App\Models\Customer;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReservationRequest extends FormRequest
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
            'proxy_reservation_type' => 'required|string|in:web,new_apply,extending',
            'day' => 'required|date_format:Y-m-d',
            'plan_less_start_time' => 'required|string|date_format:H:i',
            'plan_less_end_time' => 'required|string|date_format:H:i',
            'people_count' => 'required|integer',
            'business_structure' => 'required|string|in:organization,indivisual',
            'use_purpose_category' => 'required|string',
            'use_purpose_for_other' => 'required|string',
            'total_price_override_sans_tax' => 'required|integer',
            'limited_discount_price_sans_tax' => 'nullable|integer',
            'discount' => 'nullable|integer',
            'coupon_name' => 'nullable|string',
            'coupon_id' => 'nullable|integer',
            'customer_email' => 'required|email',
            'memo_owner' => 'nullable|string',
            'memo_customer' => 'nullable|string'
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
            'proxy_reservation_type' => '予約種別 ',
            'day' => 'ご利用日 ',
            'plan_less_start_time' => '時間・から',
            'plan_less_end_time' => '時間・まで',
            'people_count' => 'ご利用人数',
            'business_structure' => '利用者区分',
            'use_purpose_category' => '利用目的',
            'use_purpose_for_other' => '利用目的詳細',
            'total_price_override_sans_tax' => 'ご利用料金・スペース料金',
            'limited_discount_price_sans_tax' => 'ご利用料金・特別割引額',
            'discount' => 'ご利用料金・クーポン',
            'customer_email' => 'お客様情報・メールアドレス ',
            'memo_owner' => 'メモ・所有者',
            'memo_customer' => 'メモ・顧客'
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
            'proxy_reservation_type.required' => ':attributeは必須です。',
            'proxy_reservation_type.string' => ':attributeには、文字を指定してください。',
            'proxy_reservation_type.in' => '選択された:attributeは、有効ではありません。',
            'day.required' => ':attributeは必須です。 ',
            'day.date_format' => ":attributeの形式は、':format'と合いません。",
            'plan_less_start_time.required' => ':attributeは必須です。',
            'plan_less_start_time.string' => ':attributeには、文字を指定してください。',
            'plan_less_start_time.date_format' => ":attributeの形式は、':format'と合いません。",
            'plan_less_end_time.required' => ':attributeは必須です。',
            'plan_less_end_time.string' => ':attributeには、文字を指定してください。',
            'plan_less_end_time.date_format' => ":attributeの形式は、':format'と合いません。",
            'people_count.required' => ':attributeは必須です。',
            'people_count.integer' => ':attributeには、整数を指定してください。',
            'business_structure.required' => ':attributeは必須です。',
            'business_structure.string' => ':attributeには、文字を指定してください。',
            'business_structure.in' => '選択された:attributeは、有効ではありません。',
            'use_purpose_category.required' => ':attributeは必須です。',
            'use_purpose_category.string' => ':attributeには、文字を指定してください。',
            'use_purpose_for_other.required' => ':attributeは必須です。',
            'use_purpose_for_other.string' => ':attributeには、文字を指定してください。',
            'total_price_override_sans_tax.required' => ':attributeは必須です。',
            'total_price_override_sans_tax.integer' => ':attributeには、整数を指定してください。',
            'limited_discount_price_sans_tax.integer' => ':attributeには、整数を指定してください。',
            'discount.integer' => ':attributeには、整数を指定してください。',
            'customer_email.required' => ':attributeは必須です。',
            'customer_email.email' => ':attributeアドレスの形式が無効です。',
            'customer_email.exists' => '選択された:attributeは、有効ではありません。',
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
