<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Password;
use Symfony\Component\HttpFoundation\Response;

class UserManagePostRequest extends FormRequest
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
            'user_type' => 'required|string',
            'organization_id' => 'required|integer',
            'active' => 'required|boolean',
            'email' => 'required|email|unique:users',
            'password' => [
                'required',
                Password::min(8)
                    ->mixedCase()
                    ->numbers(),
            ],

            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'first_name_furigana' => 'required|string',
            'last_name_furigana' => 'required|string',
            'gender_type' => 'required|string',
            'request_notification' => 'nullable|boolean',
            'receive_newsletter' => 'nullable|boolean',
            'user.roles' => 'present|array',
            'user.working_groups' => 'present|array',
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
            'user_type.required' => ':attributeは必須です。',
            'organization_id.required' => ':attributeは必須です。',
            'organization_id.integer' => ':attribute半角数字で入力してください',
            'active.required' => ':attributeは必須です。',
            'active.boolean' => ":attributeには、'true'か'false'を指定してください。",
            'email.required' => ':attributeは必須です。',
            'password.required' => ':attributeは必須です。',
            'password.min' => ':attributeは:8文字以上で入力して下さい。',
            'first_name.required' => ':attributeは必須です。',
            'last_name.required' => ':attributeは必須です。',
            'first_name_furigana.required' => ':attributeは必須です。',
            'last_name_furigana.required' => ':attributeは必須です。',
            'files.required' => ':attributeは必須です。',
            'gender_type.required' => ':attributeは必須です。',
            'request_notification.boolean' => ":attributeには、'true'か'false'を指定してください。",
            'receive_newsletter.boolean' => ":attributeには、'true'か'false'を指定してください。",
            'user.roles.array' => ':attributeには、配列を指定してください。',
            'user.working_groups.array' => ':attributeには、配列を指定してください。',
        ];
    }

    /**
     * Determine attributes.
     *
     * @return array
     */
    public function attributes(): array
    {
        $httpHost = request()->getHttpHost();
        return [
            'user_type' =>  'ユーザータイプ',
            'organization_id' => '組織のID',
            'active' => 'アクティブ',
            'email' => 'メール',
            'password' => 'パスワード',
            'first_name' => 'ファーストネーム',
            'last_name' => 'ラストネーム',
            'first_name_furigana' => 'ファーストネームふりがな',
            'last_name_furigana' => 'ラストネームふりがな',
            'files' => 'ファイル',
            'gender_type' => '性別タイプ',
            'request_notification' => '通知リクエスト',
            'receive_newsletter' => 'ニュースレター受取',
            'user.roles' => 'ユーザーの役割',
            'user.working_groups' => 'ユーザーのワーキンググループ',
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
