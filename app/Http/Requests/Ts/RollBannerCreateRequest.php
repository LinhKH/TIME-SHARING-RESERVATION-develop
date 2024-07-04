<?php

namespace App\Http\Requests\Ts;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RollBannerCreateRequest extends FormRequest
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
            'title' => 'required',
            'type' => 'in:pick_up,space,link,blog,news',
            'post_id' => 'nullable|regex:/^[0-9]+$/',
            'submission_method' => 'nullable|regex:/^[0-9]+$/',
            'background_change' => 'nullable|regex:/^[0-9]+$/',
            'url' => 'nullable',
            'select_with' => 'nullable|regex:/^[0-9]+$/',
            'background_type_selection' => 'nullable|regex:/^[0-9]+$/',
            'color_selection' => 'nullable|regex:/^[0-9]+$/',
            'image' => [
                'nullable',
                'image',
            ],

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
