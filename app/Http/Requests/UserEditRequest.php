<?php

namespace App\Http\Requests;

use App\Rules\CheckPassword;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class UserEditRequest extends FormRequest
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
        return [
            'id' => 'sometimes|integer',
            'username' => 'sometimes|string|unique:users',
            'name' => 'sometimes|string',
            'email' => 'sometimes|email|indisposable|unique:users',
            'password' => ['sometimes', new CheckPassword()],
            'address' => 'sometimes|string',
            'mobile_no' => 'sometimes|numeric|min:10|max:10',
            'is_active' => 'sometimes|boolean',
            'department_id' => 'sometimes|numeric',
            'image' => 'image|mimes:jpg,jpeg,png,pdf|max:4096',
        ];
    }

    public function messages()
    {
        return [
            'exists' => 'Id doesn\'t exists.'
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
