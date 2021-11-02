<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class MailSettingRequest extends FormRequest
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
                'mail_host' => 'string',
                'mail_port' => 'int',
                'mail_address' => 'string',
                'password' => 'string',
                'encryption' => 'string',
                'mail_from_name' => 'string',
            ];
        } else {
            return [
                'mail_host' => 'required|string',
                'mail_port' => 'required|int',
                'mail_address' => 'required|string',
                'password' => 'required|string',
                'encryption' => 'required|string',
                'mail_from_name' => 'required|string',
            ];
        }
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
