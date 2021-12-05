<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class ProductVariantRequest extends FormRequest
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
                'product_id' => 'int|exists:products,id',
                'quantity' => 'int',
                'price' => 'int'
            ];
        } else {
            return [
                'product_id' => 'required|int|exists:products,id',
                'attribute_ids' => 'required'
            ];
        }
    }

    public function messages()
    {
        return [
            'exists' => 'Id doesn\'t exist.'
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
