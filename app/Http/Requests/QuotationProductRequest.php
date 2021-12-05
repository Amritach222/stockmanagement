<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class QuotationProductRequest extends FormRequest
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
                'quotation_id' => 'int|exists:quotations,id',
                'product_id' => 'int|exists:products,id',
                'product_variant_id' => 'int|exists:product_variants,id',
                'quantity' => 'int',
                'tax_id' => 'int|exists:taxes,id',
                'shipping_cost' => 'int',
            ];
        } else {
            return [
                'quotation_id' => 'required|int|exists:quotations,id',
                'product_id' => 'required|int|exists:products,id',
                'product_variant_id' => 'int|exists:product_variants,id',
                'quantity' => 'int',
                'tax_id' => 'int|exists:taxes,id',
                'shipping_cost' => 'int',
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
