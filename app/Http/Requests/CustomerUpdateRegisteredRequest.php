<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CustomerUpdateRegisteredRequest extends FormRequest
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
            'business_structure' => 'required|in:organization,indivisual',
            'company_name' => [
                'required',
                'max:255'
            ],

            'first_name' => [
                'required',
                'max:255'
            ],

            'last_name' => [
                'required',
                'max:255'
            ],

            'first_name_kana' => [
                'required',
                'max:255'
            ],

            'last_name_kana' => [
                'required',
                'max:255'
            ],

            'gender' => 'required|in:male,female,other,noanswer,unspecified',
            'birthday_day_ident' => 'required|regex:/^[0-9]+$/',
            'phone_number' => [
                'required',
                'max:255'
            ],

            'address' => 'required',
            'send_mail' => 'nullable',
            'email' => 'required',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
