<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RentalSpaceGeneralRequest extends FormRequest
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
            'organization_id' => 'required|integer',
            'general_basic_space_name_ja' => 'required|string|max:50',
            'general_basic_space_name_kana' => 'nullable|string',
            'general_basic_space_overview' => 'nullable|string|max:1000',
            'general_basic_space_introduction' => 'required|string',
            'general_basic_space_purpose_of_uses' => 'required',

            'general_location_post_code' => 'required|string',
            'general_location_prefecture' => 'required|string',
            'general_location_municipality' => 'required|string',
            'general_location_address_ja' => 'required|string',
            'general_location_access_instruction_ja' => 'required|string',
            'general_location_latitude' => 'nullable|numeric',
            'general_location_longitude' => 'nullable|numeric',

            'general_space_information_minimum_capacity' => 'required|integer|min:1',
            'general_space_information_maximum_capacity' => 'required|integer|gt:general_space_information_minimum_capacity',
            'general_space_information_spaciousness_description_ja' => 'required|string',
            'general_space_information_plan_ja' => 'required|string|max:1200',
            'general_space_information_minimum_duration_minutes' => 'nullable|integer',
            'general_space_information_maximum_budget' => 'nullable|numeric',
            'general_space_information_cheapest_price_guarantee' => 'nullable|boolean',
            'general_space_information_terms_of_service' => 'required|string',
            'general_space_information_cancellation_policy' => 'required|string',

            'general_contact_operating_company_ja' => 'nullable|string',
            'general_contact_person_in_charge_ja' => 'nullable|string',
            'general_contact_phone_number_ja' => 'required|string',
            'general_contact_email' => 'required|string'
        ];
    }

    /**
     * Determine attibutes.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'organization_id' => 'スペースID',
            'general_basic_space_name_ja' => 'スペース名',
            'general_basic_space_name_kana' => 'スペース名(カナ)',
            'general_basic_space_overview' => 'スペース概要',
            'general_basic_space_introduction' => 'スペース紹介',
            'general_basic_space_purpose_of_use' => '利用目的',

            'general_location_post_code' => '郵便番号',
            'general_location_prefecture' => '都道府県',
            'general_location_municipality' => '市区町村',
            'general_location_address_ja' => '所番地 建物名',
            'general_location_access_instruction_ja' => '駅からのアクセス方法',
            'general_location_latitude' => '緯度',
            'general_location_longitude' => '経度',

            'general_space_information_minimum_capacity' => '人数~minimum',
            'general_space_information_maximum_capacity' => '人数~maximum',
            'general_space_information_spaciousness_description_ja' => '広さ ',
            'general_space_information_plan_ja' => '料金プラン（利用可能時間・曜日・料金）',
            'general_space_information_minimum_duration_minutes' => '最小持続時間',
            'general_space_information_maximum_budget' => '最大予算',
            'general_space_information_cheapest_price_guarantee' => '最安価格',
            'general_space_information_terms_of_service' => '利用規約',
            'general_space_information_cancellation_policy' => 'キャンセルポリシー',

            'general_contact_operating_company_ja' => '運営会社',
            'general_contact_person_in_charge_ja' => '担当者',
            'general_contact_phone_number_ja' => '電話番号',
            'general_contact_email' => 'メールアドレス'
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
            'organization_id.required' => ':attributeは必須です。',
            'organization_id.integer' => ':attributeには、整数を指定してください。',
            'general_basic_space_name_ja.required' => ':attributeは必須です。',
            'general_basic_space_name_ja.string' => ':attributeは:min文字以上で入力して下さい。',
            'general_basic_space_name_ja.max' => ':attributeは:max文字以内で入力してください。',
            'general_basic_space_name_kana.string' => ':attributeは:min文字以上で入力して下さい。',
            'general_basic_space_overview.string' => ':attributeは:min文字以上で入力して下さい。',
            'general_basic_space_overview.max' => ':attributeは:max文字以内で入力してください。',
            'general_basic_space_introduction.required' => ':attributeは必須です。',
            'general_basic_space_introduction.string' => ':attributeは:min文字以上で入力して下さい。',
            'general_basic_space_introduction.max' => ':attributeは:max文字以内で入力してください。',
            'general_basic_space_purpose_of_uses.required' => ':attributeは必須です。',

            'general_location_post_code.required' => ':attributeは必須です。',
            'general_location_post_code.string' => ':attributeは:min文字以上で入力して下さい。',
            'general_location_prefecture.required' => ':attributeは必須です。',
            'general_location_prefecture.string' => ':attributeは:min文字以上で入力して下さい。',
            'general_location_municipality.required' => ':attributeは必須です。',
            'general_location_municipality.string' => ':attributeは:min文字以上で入力して下さい。',
            'general_location_address_ja.required' => ':attributeは必須です。',
            'general_location_address_ja.string' => ':attributeは:min文字以上で入力して下さい。',
            'general_location_access_instruction_ja.required' => ':attributeは必須です。',
            'general_location_access_instruction_ja.string' => ':attributeは:min文字以上で入力して下さい。',
            'general_location_latitude.numeric' => ':attributeには、数字を指定してください。',
            'general_location_longitude.numeric' => ':attributeには、数字を指定してください。',

            'general_space_information_minimum_capacity.required' => ':attributeは必須です。',
            'general_space_information_minimum_capacity.integer' => ':attributeには、整数を指定してください。',
            'general_space_information_minimum_capacity.min' => '人数の最小値は少なくとも 1 でなければなりません。',
            'general_space_information_maximum_capacity.required' => ':attributeは必須です。',
            'general_space_information_maximum_capacity.integer' => ':attributeには、整数を指定してください。',
            'general_space_information_maximum_capacity.gt' => '人数の最大値は 最小値よりでなければなりません。',
            'general_space_information_spaciousness_description_ja.required' => ':attributeは必須です。',
            'general_space_information_spaciousness_description_ja.string' => ':attributeは:min文字以上で入力して下さい。',
            'general_space_information_plan_ja.required' => ':attributeは必須です。',
            'general_space_information_plan_ja.string' => ':attributeは:min文字以上で入力して下さい。',
            'general_space_information_plan_ja.max' => ':attributeは:max文字以内で入力してください。',
            'general_space_information_minimum_duration_minutes.integer' => ':attributeには、整数を指定してください。',
            'general_space_information_maximum_budget.numeric' => ':attributeには、数字を指定してください。',
            'general_space_information_terms_of_service.required' => ':attributeは必須です。',
            'general_space_information_terms_of_service.string' => ':attributeは:min文字以上で入力して下さい。',
            'general_space_information_cancellation_policy.required' => ':attributeは必須です。',
            'general_space_information_cancellation_policy.string' => ':attributeは:min文字以上で入力して下さい。',
            'general_contact_operating_company_ja.string' => ':attributeは:min文字以上で入力して下さい。',
            'general_contact_phone_number_ja.required' => ':attributeは必須です。',
            'general_contact_phone_number_ja.string' => ':attributeは:min文字以上で入力して下さい。',
            'general_contact_email.required' => ':attributeは必須です。',
            'general_contact_email.string' => ':attributeは:min文字以上で入力して下さい。'
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
