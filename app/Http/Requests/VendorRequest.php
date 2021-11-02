<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class VendorRequest extends FormRequest
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
                'company_name' => 'string',
                'vat_no' => 'int',
                'landline' => 'int',
                'mobile' => 'int',
                'category_id' => 'int|exists:categories,id'
            ];
        } else {
            return [
                'name' => 'required|string',
                'company_name' => 'required|string',
                'vat_no' => 'required|int',
                'email' => 'required',
                'landline' => 'int',
                'mobile' => 'required|int',
                'category_id' => 'int|exists:categories,id'
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
