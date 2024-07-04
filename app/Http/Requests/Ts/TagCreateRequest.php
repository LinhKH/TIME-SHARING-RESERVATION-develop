<?php

namespace App\Http\Requests\Ts;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;


class TagCreateRequest extends FormRequest
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
            'name' => [
                'required',
                'max:255',
                Rule::unique('ts_tags')->whereNull('deleted_at'),
                'regex:/^[^@#$%`^&*]+$/'
            ],

            'slug' => [
                'nullable',
                'max:255',
                Rule::unique('ts_tags')->whereNull('deleted_at'),
                'regex:/^[^@#$%`^&*]+$/'
            ],

            'status' => 'nullable|regex:/^[0-1]+$/',
            'description' => 'nullable',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
