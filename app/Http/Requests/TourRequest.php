<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class TourRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'first_choice_date' => 'required',
            'first_choice_time' => 'required',
            'use_plans_date' => 'required',
            'use_plans_people' => 'required|numeric',
            'use_purpose' => 'required',
            'use_purpose_detail' => 'required',
            'checklist' => 'required'
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
            'first_choice_date' => '第1希望',
            'first_choice_time' => '第1希望',
            'use_plans_date' => '利用予定日時',
            'use_plans_people' => '利用予定人数',
            'use_purpose' => '利用用途',
            'use_purpose_detail' => '用途詳細',
            'checklist' => '見学で確認したい点'
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
            'first_choice_date.required' => ':attributeは必須です。',
            'first_choice_time.required' => ':attributeは必須です。',
            'use_plans_date.required' => ':attributeは必須です。',
            'use_plans_people.required' => ':attributeは必須です。',
            'use_plans_people.numeric' => ':attributeには、数字を指定してください。',
            'use_purpose.required' => ':attributeは必須です。',
            'use_purpose_detail.required' => ':attributeは必須です。',
            'checklist.required' => ':attributeは必須です。'
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

