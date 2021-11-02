<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemVariant extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'item_id' => $this->item_id,
            'code' => $this->code,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'image_ids' => $this->image_ids,
            'item_variant_attributes' => $this->itemVariantAttributes,
        ];
    }
}
