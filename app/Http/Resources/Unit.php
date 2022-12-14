<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Unit extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $category = new UnitCategory($this->category);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'short_code' => $this->short_code,
            'category_id' => $this->category_id,
            'type' => $this->type,
            'value' => $this->value,
            'category' => $category,
        ];
    }
}
