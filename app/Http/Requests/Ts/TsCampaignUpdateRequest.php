<?php

namespace App\Http\Requests\Ts;

use App\Models\RentalSpace;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class TsCampaignUpdateRequest extends FormRequest
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
            'title' => [
                'required',
                'max:255',
            ],

            'body' => 'nullable',
            'kinds' => 'in:discount,decoration,single',
            'start_date' => 'required',
            'end_date' => 'required',
            'list_title' => [
                'nullable',
                'max:255',
            ],

            'list_content' => [
                'nullable',
                'max:255',
            ],

            'title_background' => [
                'nullable',
                'image',
            ],

            'title_recommendation' => [
                'nullable',
                'max:255',
            ],

            'notes' => 'nullable',

            'comment_recommendation' => [
                'nullable',
                'max:255',
            ],

            'space_recommendation' => [
                'nullable',
                Rule::exists(RentalSpace::class, 'id')
            ],

            'title_background_recommendation' => [
                'nullable',
                'image',
            ],

            'campaign_spaces' => 'nullable',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
