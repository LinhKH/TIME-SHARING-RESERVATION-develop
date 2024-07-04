<?php


namespace App\Http\Requests;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class TourNonApprovalRequest extends FormRequest
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
            'no_reason' => 'required|numeric|between:1,3',
            'substitude_first_choice_date' => 'required_if:no_reason,=,1',
            'substitude_first_choice_time' => 'required_if:no_reason,=,1',
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
            'no_reason' => '見学不可の理由',
            'substitude_first_choice_date' => '第1希望日',
            'substitude_first_choice_time' => '第1希望日の時刻'
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
            'no_reason.required' => ':attributeは必須です。',
            'no_reason.numeric' => ':attributeには、数字を指定してください。',
            'no_reason.between' => ':attributeには、:minから、:maxまでの数字を指定してください。',
            'substitude_first_choice_date.required_if' => ':attributeを入力してください',
            'substitude_first_choice_time.required_if' => ':attributeを入力してください'
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
