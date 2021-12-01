<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductAttribute extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $attribute_group = new ProductAttributeGroup($this->productAttributeGroup);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'attribute_group_id' => $this->attribute_group_id,
            'attribute_group' => $attribute_group->name ?? '',
        ];
    }
}
