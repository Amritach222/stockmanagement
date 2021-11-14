<?php

namespace App\Http\Resources;

use App\Models\File;
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
        $user = new AuthResource($this->user);
        $approver = new AuthResource($this->approver);
        $fiscalYear = new AuthResource($this->fiscalYear);
        $link = null;
        if ($this->file_id != null) {
            $file = File::find($this->file_id);
            $link = $file->path;
        }
        $budgetRequestCategories = BudgetRequestCategory::collection($this->budgetRequestCategories);
        return [
            'id' => $this->id,
            'department_id' => $this->department_id,
            'user_id' => $this->user_id,
            'fiscal_year_id' => $this->fiscal_year_id,
            'type' => $this->type,
            'request_amount' => $this->request_amount,
            'status' => $this->status,
            'approved_by' => $this->approved_by,
            'remarks' => $this->remarks,
            'file_id' => $this->file_id,
            'department' => $department,
            'user' => $user,
            'approver' => $approver,
            'fiscal_year' => $fiscalYear,
            'link' => $link,
            'budget_request_categories' => $budgetRequestCategories,
        ];
    }
}
