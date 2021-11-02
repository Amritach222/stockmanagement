<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class SettingRequest extends FormRequest
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
                'title' => 'string',
                'fiscal_year_id' => 'sometimes|int|exists:fiscal_years,id',
                'currency' => 'sometimes|string',
                'time_zone' => 'sometimes|string',
                'date_format' => 'sometimes|string',
                'image' => 'image|mimes:jpg,jpeg,png,pdf|max:4096',
            ];
        } else {
            return [
                'title' => 'required|string',
                'fiscal_year_id' => 'sometimes|int|exists:fiscal_years,id',
                'currency' => 'sometimes|string',
                'time_zone' => 'sometimes|string',
                'date_format' => 'sometimes|string',
                'image' => 'image|mimes:jpg,jpeg,png,pdf|max:4096',
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
