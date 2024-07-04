<?php

namespace App\Http\Requests\Ts;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class CategorySpaceUpdateRequest extends FormRequest
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
                'nullable',
                'max:255',
                'regex:/^[^@#$%`^&*]+$/'
            ],

            'slug' => [
                'nullable',
                'max:255',
                'regex:/^[^@#$%`^&*]+$/'
            ],

            'status' => 'nullable|regex:/^[0-1]+$/',
            'file' => [
                'nullable',
                'image',
            ],

            'description' => 'nullable',
            'purpose_of_use_wording' => 'nullable',
            'purpose_of_use' => 'nullable',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
