<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class ProductRequest extends FormRequest
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
        if ($this->id) {
            return [
                'name' => 'string',
                'brand_id' => 'int|exists:brands,id',
                'category_id' => 'int|exists:categories,id',
                'details' => 'sometimes',
                'image' => 'sometimes|image|mimes:jpg,jpeg,png,pdf|max:4096'
            ];
        } else {
            return [
                'name' => 'required|string',
                'brand_id' => 'required|int|exists:brands,id',
                'category_id' => 'required|int|exists:categories,id',
                'details' => 'sometimes',
                'image' => 'sometimes|image|mimes:jpg,jpeg,png,pdf|max:4096'
            ];
        }
    }

    public function messages()
    {
        return [
            'exists' => 'Id doesn\'t exist.',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = new JsonResponse([
            'success' => false,
            'message' => trans('messages.error_data'),
            'data' => $validator->errors()
        ], 422);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
