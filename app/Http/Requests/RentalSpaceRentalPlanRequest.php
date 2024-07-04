<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RentalSpaceRentalPlanRequest extends FormRequest
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
            'plan_name' => 'required|string'
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
            'plan_name' => '通常プラン'
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
            'plan_name.required' => ':attributeは必須です。',
            'plan_name.string' => ':attributeには、文字を指定してください。',
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
