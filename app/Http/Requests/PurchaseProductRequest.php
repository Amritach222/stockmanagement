<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class PurchaseProductRequest extends FormRequest
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
                'product_id' => 'int|exists:products,id',
                'product_variant_id' => 'int|exists:product_variants,id',
                'vendor_id' => 'int|exists:vendors,id',
                'quantity' => 'int|min:1',
                'tax_id' => 'int|exists:taxes,id',
                'status' => 'string',
                'unit_id' => 'int|exists:units,id',
            ];
        } else {
            return [
                'purchase_id' => 'required|int|exists:purchases,id',
                'product_id' => 'required|int|exists:products,id',
                'product_variant_id' => 'int|exists:product_variants,id',
                'vendor_id' => 'int|exists:vendors,id',
                'quantity' => 'int|min:1',
                'tax_id' => 'int|exists:taxes,id',
                'status' => 'string',
                'unit_id' => 'int|exists:units,id',
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
