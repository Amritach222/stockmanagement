<?php

namespace App\Http\Requests;

use App\Rules\CheckPassword;
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
                'company_name' => 'string',
                'vat_no' => 'int',
                'landline' => 'int',
                'category_id' => 'int|exists:categories,id',
                'email' => 'email|indisposable',
                'username' => 'string',
                'name' => 'string|max:50',
                'department_id' => 'sometimes|numeric|exists:departments,id',
                'designation_id' => 'sometimes|numeric|exists:designations,id',
                'mobile' => 'min:10|max:10',
                'address' => 'sometimes|string'
            ];
        } else {
            return [
                'company_name' => 'required|string',
                'vat_no' => 'required|int',
                'landline' => 'int',
                'category_id' => 'int|exists:categories,id',
                'email' => 'required|email|indisposable|unique:users',
                'username' => 'required|unique:users',
                'name' => 'required|string|max:50',
                'confirm_password' => 'required|min:8|max:16|same:password',
                'password' => ['required', new CheckPassword()],
                'mobile' => 'required|min:10|max:10',
                'address' => 'sometimes|string'
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
