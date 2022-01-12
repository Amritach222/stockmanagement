<?php

namespace App\Http\Requests;

use App\Rules\CheckPassword;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class VendorQuotationRequest extends FormRequest
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
                'quotation_product_id' => 'int|exists:quotation_products,id',
                'vendor_id' => 'int|exists:vendors,id',
                'price' => 'sometimes|int',
                'quantity' => 'sometimes|int',
            ];
        } else {
            return [
                'quotation_id' => 'required|int|exists:quotations,id',
                'quotation_product_id' => 'required|int|exists:quotation_products,id',
                'vendor_id' => 'required|int|exists:vendors,id',
                'price' => 'sometimes|int',
                'quantity' => 'sometimes|int',
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
