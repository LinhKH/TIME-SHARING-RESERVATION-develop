<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class RentalSpacePageAndEmailMessageRequest extends FormRequest
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
            'term_of_use' => 'required|string',
            'cancellation_policy'=> 'required|string',
            'prohibited_matter' => 'nullable|string',
            'faq' => 'nullable|string',
            'notices' => 'nullable|string',
            'note_from_space' => 'nullable|string',
            'questions_from_space' => 'nullable|string',
            'reservation_creation' => 'nullable|string',
            'reservation_after_payment' => 'nullable|string',
            'tomorrows_reminder' => 'nullable|string'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'term_of_use.required' => ':attributeは必須です。',
            'term_of_use.string' => ':attributeには、文字を指定してください。',
            'cancellation_policy.required'=> ':attributeは必須です。',
            'cancellation_policy.string'=> ':attributeには、文字を指定してください。',
            'prohibited_matter.string' => ':attributeには、文字を指定してください。',
            'faq.string' => ':attributeには、文字を指定してください。',
            'notices.string' => ':attributeには、文字を指定してください。',
            'note_from_space.string' => ':attributeには、文字を指定してください。',
            'questions_from_space.string' => ':attributeには、文字を指定してください。',
            'reservation_creation.string' => ':attributeには、文字を指定してください。',
            'reservation_after_payment.string' => ':attributeには、文字を指定してください。',
            'tomorrows_reminder.string' => ':attributeには、文字を指定してください。'
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
            'term_of_use' => '利用規約',
            'cancellation_policy'=> 'キャンセルポリシー',
            'prohibited_matter' => '禁止事項 ',
            'faq' => 'よくある質問',
            'notices' => 'お知らせ',
            'note_from_space' => 'スペースからの連絡事項 ',
            'questions_from_space' => 'スペースからの確認事項 ',
            'reservation_creation' => '予約完了時のメール',
            'reservation_after_payment' => '利用料金の支払い完了時のメール ',
            'tomorrows_reminder' => '利用日の前日のリマインドメール '
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
