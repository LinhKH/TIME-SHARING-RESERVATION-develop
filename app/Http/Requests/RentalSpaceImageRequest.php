<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class RentalSpaceImageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @param Request $request
     * @return array
     */
    public function rules(Request $request): array
    {
        $data = $request->all();
        $rules = [];
        $countImageType = 0;

        if ($request->has('information_images') && !empty($data['information_images'])) {
            foreach($data['information_images'] as $key => $informationImage){
                $rules['path_file'] = 'string';
                $rules['title_image'] = 'string';
                $rules['type'] = 'string';
                $rules['width'] = 'integer|min:0';
                $rules['height'] = 'integer|min:0';
                $rules['length'] = 'integer|min:0';
                $rules['order_number'] = 'integer|min:0';
                $rules['extension'] = 'mimes:jpg,png,jpeg,bmp';
                if ($informationImage['type'] === 'image') {
                    $countImageType += 1;
                }
            }
        }

        if ($countImageType == 0 || $countImageType > 50 || empty($data['information_images'])) {
            $rules['information_images'] = 'required';
        }
        return $rules;
    }

    /**
     * Determine attributes.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'information_images.*' => '画像'
        ];
    }

    /**
     * Determine message.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'information_images.*.required' => '画像は必須です。1枚以上の画像を登録して下さい。',
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
