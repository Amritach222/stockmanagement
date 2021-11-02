<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BudgetRequest extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $department = new Department($this->department);
        return [
            'id' => $this->id,
            'department_id' => $this->department_id,
            'request_amount' => $this->request_amount,
            'request_amount_time' => $this->request_amount_time,
            'status' => $this->status,
            'department_name' => $department->name ?? '',
            'department' => $department,
        ];
    }
}
