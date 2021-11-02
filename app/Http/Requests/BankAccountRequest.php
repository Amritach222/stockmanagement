<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class BankAccountRequest extends FormRequest
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
                'bank_name' => 'string',
                'account_no' => 'string',
                'account_name' => 'string',
                'total_balance' => 'int',
                'current_balance' => 'int',
                'bank_branch' => 'string',
            ];
        }else{
            return [
                'bank_name' => 'required|string',
                'account_no' => 'required|string',
                'account_name' => 'required|string',
                'total_balance' => 'int',
                'current_balance' => 'int',
                'bank_branch' => 'string',
            ];
        }
    }

    public function messages()
    {
        return [
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
