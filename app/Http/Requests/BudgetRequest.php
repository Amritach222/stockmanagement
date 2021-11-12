<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class BudgetRequest extends FormRequest
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
                'department_id' => 'int|exists:departments,id',
                'fiscal_year_id' => 'int|exists:fiscal_years,id',
                'allocated_budget_amount' => 'int|min:0',
                'initial_dispatched_amount' => 'int|min:0',
            ];
        } else {
            return [
                'title' => 'required|string',
                'department_id' => 'required|int|exists:departments,id',
                'fiscal_year_id' => 'required|int|exists:fiscal_years,id',
                'allocated_budget_amount' => 'required|int|min:0',
                'initial_dispatched_amount' => 'required|int|min:0',
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
