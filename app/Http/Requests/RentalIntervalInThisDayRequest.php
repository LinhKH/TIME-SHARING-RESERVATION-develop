<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class RentalIntervalInThisDayRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'month' => 'required|string',
            'year' => 'required|string'
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
            'month' => 'month',
            'year' => 'year'
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
            'month.required' => ':attributeは必須です。',
            'month.string' => ':attributeには、文字を指定してください。',
            'month.date_format' => ":attributeの形式は、':format'と合いません。",
            'year.required' => ':attributeは必須です。',
            'year.string' => ':attributeには、文字を指定してください。',
            'year.date_format' => ":attributeの形式は、':format'と合いません。",
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
