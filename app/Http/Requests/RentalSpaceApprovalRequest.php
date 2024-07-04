<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RentalSpaceApprovalRequest extends FormRequest
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
            'status' => 'required|string|in:published,archived,pending,pending-approval'
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
            'status' => 'ステータス'
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
            'status.required' => ':attributeは必須です。',
            'status.string' => ':attributeには、文字を指定してください。',
            'status.in' => '選択された:attributeは、有効ではありません。:attributeは「published,archived,pending,pending-approval」のいずれかの値です'
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
