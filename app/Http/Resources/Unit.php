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
        $children = Unit::collection($this->children);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'short_code' => $this->short_code,
            'parent_id' => $this->parent_id,
            'value' => $this->value,
            'children' => $children,
        ];
    }
}
