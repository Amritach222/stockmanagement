<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BudgetLimit extends JsonResource
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
            'category_id' => $this->category_id,
            'amount' => $this->amount,
            'category_name' => $category->name ?? '',
            'category' => $category,
        ];
    }
}
