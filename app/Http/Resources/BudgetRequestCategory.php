<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BudgetRequestCategory extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $category = new Category($this->category);
        return [
            'id' => $this->id,
            'budget_request_id' => $this->budget_request_id,
            'category_id' => $this->category_id,
            'amount' => $this->amount,
            'note' => $this->note,
            'category' => $category,
        ];
    }
}
