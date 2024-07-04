<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class SystemConfigSummaryPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize(): bool
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
            'active' => 'required',
            'access_key' => 'required|unique:rental_space_compilation',
            'title_ja' => 'required',
            'use_purpose_category' => 'required',
            'subtitle_ja' => 'required',
            'summary_ja' => 'required'
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
            'active' => '有効',
            'access_key' => ' アクセスキー',
            'title_ja' => 'タイトル',
            'use_purpose_category' => '用途',
            'subtitle_ja' => 'サブタイトル',
            'summary_ja' => '要約',
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
            'active.required' => ':attributeは必須です。',
            'access_key.required' => ':attributeは必須です。',
            'title_ja.required' => ':attributeは必須です。',
            'use_purpose_category.required' => ':attributeは必須です。',
            'subtitle_ja.required' => ':attributeは必須です。',
            'summary_ja.required' => ':attributeは必須です。',
            'access_key' => '指定の:attributeは既に使用されています。'
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
