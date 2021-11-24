<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemAttribute extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $attribute_group = new ItemAttributeGroup($this->itemAttributeGroup);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'attribute_group_id' => $this->attribute_group_id,
            'attribute_group' => $attribute_group->name ?? '',
        ];
    }
}
