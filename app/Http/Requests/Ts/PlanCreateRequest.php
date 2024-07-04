<?php

namespace App\Http\Requests\Ts;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;


class PlanCreateRequest extends FormRequest
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
                Rule::unique('ts_plans')->whereNull('deleted_at'),
                'regex:/^[^@#$%`^&*]+$/'
            ],

            'slug' => [
                'nullable',
                'max:255',
                Rule::unique('ts_plans')->whereNull('deleted_at'),
                'regex:/^[^@#$%`^&*]+$/'
            ],

            'status' => 'nullable|regex:/^[0-1]+$/',
            'description' => 'nullable',
            'price' => 'nullable|regex:/^[0-9]+$/',
            'number_of_guests' => 'nullable|regex:/^[0-9]+$/',
            'cooking' => [
                'nullable',
                'max:255',
                'regex:/^[^@#$%`^&*]+$/'
            ],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
