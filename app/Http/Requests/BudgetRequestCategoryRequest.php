<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class BudgetRequestCategoryRequest extends FormRequest
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
                'budget_request_id' => 'int|exists:budget_requests,id',
                'category_id' => 'int|exists:categories,id',
                'amount' => 'int|min:0',
                'note' => 'sometimes',
            ];
        } else {
            return [
                'budget_request_id' => 'required|int|exists:budget_requests,id',
                'category_id' => 'required|int|exists:categories,id',
                'amount' => 'required|int|min:0',
                'note' => 'sometimes',
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