<?php

namespace App\Http\Resources;

use App\Models\File;
use Illuminate\Http\Resources\Json\JsonResource;

class Budget extends JsonResource
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
        $fiscal_year = new FiscalYear($this->fiscalYear);
        $link = null;
        if ($this->file_id !== null) {
            $image = File::where('id', $this->file_id)->first();
            $link = $image->path;
        }
        return [
            'id' => $this->id,
            'title' => $this->title,
            'department_id' => $this->department_id,
            'fiscal_year_id' => $this->fiscal_year_id,
            'allocated_budget_amount' => $this->allocated_budget_amount,
            'initial_dispatched_amount' => $this->initial_dispatched_amount,
            'total_dispatched_amount' => $this->total_dispatched_amount,
            'date_first_received' => $this->date_first_received,
            'remarks' => $this->remarks,
            'file_id' => $this->file_id,
            'department' => $department,
            'fiscal_year' => $fiscal_year,
            'link' => $link,
        ];
    }
}
