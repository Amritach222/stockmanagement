<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class TransferRequest extends FormRequest
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
                'from' => 'int|exists:departments,id',
                'to' => 'int|exists:departments,id',
                'item_id' => 'int|exists:items,id',
                'total_quantity' => 'int|min:1',
                'tax_id' => 'int|exists:taxes,id',
                'shipping_cost' => 'int'
            ];
        } else {
            return [
                'from' => 'required|int|exists:departments,id',
                'to' => 'required|int|exists:departments,id',
                'item_id' => 'required|int|exists:items,id',
                'total_quantity' => 'int|min:1',
                'tax_id' => 'int|exists:taxes,id',
                'shipping_cost' => 'int'
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
