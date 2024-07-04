<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RentalSpaceUpdateTsRequest extends FormRequest
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
            'area_id' => 'nullable|exists:areas,id|regex:/^[0-9]+$/',
            'ts_category_spaces_id.*' => 'nullable|exists:ts_category_spaces,id|regex:/^[0-9]+$/',
            'ts_tag_id.*' => 'nullable|exists:ts_tags,id|regex:/^[0-9]+$/',
            'attribute' => 'nullable',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
