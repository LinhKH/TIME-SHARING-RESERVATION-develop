<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class ConfigCsvExportRequest  extends FormRequest
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
            'config_csv_export_items' => 'nullable|array',
            'config_csv_export_items.*.id' => 'required|integer',
            'config_csv_export_items.*.target' => 'required|string|in:spaces,customers,contact-form,catering-inquiry-form,users,organizations,inquiries,yakatabune-inquiry,space-search-form,reservations,rental-space-reviews',
            'config_csv_export_items.*.shown' => 'required|integer|in:0,1'
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
            'config_csv_export_items.array' => ':attributeには、配列を指定してください。',
            'config_csv_export_items.*.id.required' => ':attributeは必須です。',
            'config_csv_export_items.*.id.integer' => ':attributeには、整数を指定してください。',
            'config_csv_export_items.*.target.string' => ':attributeには、文字を指定してください。',
            'config_csv_export_items.*.target.required' => ':attributeは必須です。',
            'config_csv_export_items.*.target.in' => '選択された:attributeは、有効ではありません。:attributeは「spaces,customers,contact-form,catering-inquiry-form,users,organizations,inquiries,yakatabune-inquiry,space-search-form,reservations,rental-space-reviews」のいずれかの値です',
            'config_csv_export_items.*.shown.integer' => ':attributeには、整数を指定してください。',
            'config_csv_export_items.*.shown.required' => ':attributeは必須です。',
            'config_csv_export_items.*.shown.in' => '選択された:attributeは、有効ではありません。:attributeは「0,1」のいずれかの値です',
        ];
    }

    /**
     * Determine attributes.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'id' => 'ID',
            'target' => 'TARGET',
            'shown' => 'SHOWN',
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
