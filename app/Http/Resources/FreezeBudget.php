<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FreezeBudget extends JsonResource
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
        $fiscalYear = new FiscalYear($this->fiscalYear);
        return [
            'id' => $this->id,
            'department_id' => $this->department_id,
            'fiscal_year_id' => $this->fiscal_year_id,
            'amount' => $this->amount,
            'remark' => $this->remark,
            'department_name' => $department->name ?? '',
            'department' => $department,
            'fiscal_year' => $fiscalYear,
        ];
    }
}
