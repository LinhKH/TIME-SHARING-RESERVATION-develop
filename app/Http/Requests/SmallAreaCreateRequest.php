<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class SmallAreaCreateRequest extends FormRequest
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
            'title__en' => [
                'nullable',
                'max:255',
            ],

            'title__ja' => [
                'required',
                'max:255',
            ],

            'title__ja_kana' => [
                'nullable',
                'max:255',
            ],

            'identifier' => [
                'nullable',
                'max:255',
            ],

            'legacy_id' => [
                'nullable',
                'max:255',
            ],

            'parent_id' => 'nullable|exists:area_group,id|regex:/^[0-9]+$/',
            'active' => 'required|regex:/^[0-9]+$/',
            'attribute' => 'nullable',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
