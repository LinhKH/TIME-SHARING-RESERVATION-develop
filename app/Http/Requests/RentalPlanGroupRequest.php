<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RentalPlanGroupRequest extends FormRequest
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
            'plan_group_name' => 'required|string',
            'plans' => 'nullable|array',
            'plans.*.plan_id' => 'integer',
            'plans.*.status' => 'string|in:active,archived',
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
            'status' => 'ステータス',
            'plan_group_name' => ' グループ名',
            'plan_id' => 'グループID',
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
            'plans.*.status.string' => ':attributeには、文字を指定してください。',
            'plans.*.status.in' => '選択された:attributeは、有効ではありません。:attributeは「active,archived」のいずれかの値です',
            'plan_group_name.required' => ':attributeは必須です。',
            'plan_group_name.string' => ':attributeには、文字を指定してください。',
            'plans' => ':attributeには、配列を指定してください。',
            'plans.*.plan_id' => ':attributeには、整数を指定してください。'
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
