<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SystemConfigEmailTemplateRequest extends FormRequest
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
            'email_type' => 'required|string',
            'email_subject_en' => 'nullable|string',
            'email_subject_jp' => 'required|string',
            'content_en' => 'nullable|string',
            'content_jp' => 'required|string',
            'memo_en' => 'nullable|string',
            'memo_jp' => 'nullable|string'
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
            'email_type' => 'メール種別',
            'email_subject_en' => 'メール件名EN',
            'email_subject_jp' => 'メール件名JP',
            'content_en' => '内容EN',
            'content_jp' => '内容JP',
            'memo_en' => 'メモEN',
            'memo_jp' => 'メモJP'
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
            'email_type.required' => ':attributeは必須です。',
            'email_subject_en.required' => ':attributeは必須です。',
            'email_subject_jp.required' => ':attributeは必須です。',
            'content_en.required' => ':attributeは必須です。',
            'content_jp.required' => ':attributeは必須です。'

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
