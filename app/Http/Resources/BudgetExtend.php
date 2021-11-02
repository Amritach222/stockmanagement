<?php

namespace App\Http\Resources;

use App\Models\File;
use Illuminate\Http\Resources\Json\JsonResource;

class BudgetExtend extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $approver = new AuthResource($this->approver);
        $department = new Department($this->department);
        $link = null;
        if ($this->file_id !== null) {
            $image = File::where('id', $this->file_id)->first();
            $link = $image->path;
        }
        return [
            'id' => $this->id,
            'department_id' => $this->department_id,
            'amount' => $this->amount,
            'status' => $this->status,
            'approved_by' => $this->approved_by,
            'remarks' => $this->remarks,
            'file_id' => $this->file_id,
            'link' => $link,
            'approver' => $approver,
            'department' => $department,
        ];
    }
}
