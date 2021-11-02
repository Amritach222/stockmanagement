<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class ReturnProductRequest extends FormRequest
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
                'purchase_id' => 'int|exists:purchases,id',
                'purchase_product_id' => 'int|exists:purchase_products,id',
                'quantity' => 'int|min:1',
                'note' => 'sometimes',
            ];
        } else {
            return [
                'purchase_id' => 'required|int|exists:purchases,id',
                'purchase_product_id' => 'required|int|exists:purchase_products,id',
                'quantity' => 'required|int|min:1',
                'note' => 'sometimes',
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
