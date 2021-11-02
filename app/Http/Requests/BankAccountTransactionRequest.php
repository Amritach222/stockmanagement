<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class BankAccountTransactionRequest extends FormRequest
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
                'account_id' => 'int|exists:bank_accounts,id',
                'transaction_amount' => 'int',
                'transaction_type' => 'string',
            ];
        } else {
            return [
                'account_id' => 'required|int|exists:bank_accounts,id',
                'transaction_amount' => 'int',
                'transaction_type' => 'string',
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
