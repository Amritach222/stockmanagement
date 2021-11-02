<?php

namespace App\Http\Requests;

use App\Rules\CheckPassword;
use App\Rules\CheckUsernameOrEmail;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class UserPasswordReset extends FormRequest
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
            'usernameOrEmail' => ['required', new CheckUsernameOrEmail()],
            'previousPassword' => ['required', new CheckPassword()],
            'newPassword' => ['required', new CheckPassword()],
            'confirmNewPassword' => ['required','same:newPassword', new CheckPassword()]
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
