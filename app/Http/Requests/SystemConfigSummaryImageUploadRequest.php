<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class SystemConfigSummaryImageUploadRequest extends FormRequest
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
            'name' => 'required',
            'type' => 'required|numeric|between:1,4',
            'width' => 'required',
            'height' => 'required',
            'extension' => 'required',
            's3key' => 'required',
            'length' => 'required'
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
            'name' => 'name',
            'type' => ' type',
            'width' => 'width',
            'height' => 'height',
            'extension' => 'extension',
            's3key' => 's3key',
            'length' => 'length'
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
            'name.required' => ':attributeは必須です。',
            'type.required' => ':attributeは必須です。',
            'type.between' => ':attributeには、:minから、:maxまでの数字を指定してください。',
            'type.numeric' => ':attributeには、数字を指定してください。',
            'width.required' => ':attributeは必須です。',
            'height.required' => ':attributeは必須です。',
            'extension.required' => ':attributeは必須です。',
            's3key.required' => ':attributeは必須です。',
            'length' => '指定の:attributeは既に使用されています。'
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
