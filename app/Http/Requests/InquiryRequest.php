<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class InquiryRequest extends FormRequest
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
            'tour_id' => 'nullable|exists:tours,id',
            'inquiry_typeWF' => 'nullable|in:space,reservation,tour',
            'created_by' => 'nullable|in:customer,user',
            'organization_id' => 'nullable|exists:organization,id',
            'rental_space_id' => 'nullable|exists:rental_space,id',
            'reservation_id' => 'nullable|unique:inquiry|exists:reservation,id',
            'title' => [
                'nullable',
                'max:255',
            ],

            'description' => 'required',
            'from_ads_section' => [
                'nullable',
                'max:45',
            ],

            'support_done' => 'nullable|regex:/^[0-9]+$/',
            'support_status' => [
                'nullable',
                'max:255',
            ],

            'person_in_charge' => [
                'nullable',
                'max:255',
            ],

            'internal_notes' => 'nullable',
            'reminded_time' => 'nullable|regex:/^[0-9]+$/',
            'is_read' => 'nullable|regex:/^[0-9]+$/',
            'space_search_form_id' => 'nullable|regex:/^[0-9]+$/',
            'offer_rental_space_id' => 'nullable|regex:/^[0-9]+$/',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
