<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class SignatureUseDepartmentRequest extends FormRequest
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
                'department_id' => 'int|exists:departments,id',
                'signature_id' => 'int|exists:signatures,id'
            ];
        } else {
            return [
                'department_id' => 'required|int|exists:departments,id',
                'signature_id' => 'required|int|exists:signatures,id'
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
