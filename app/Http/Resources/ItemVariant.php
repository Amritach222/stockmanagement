<?php

namespace App\Http\Resources;

use App\Models\File;
use App\Models\ItemVariantAttribute;
use App\Models\ItemAttribute;
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
        $link = null;
        if ($this->image_id !== null) {
            $image = File::where('id', $this->image_id)->first();
            $link = $image->path;
        }
        $variantAttributeIds = ItemVariantAttribute::where('item_variant_id', $this->id)->pluck('attribute_id');
        $attributeGroupIds = ItemAttribute::whereIn('id', $variantAttributeIds)->pluck('attribute_group_id');
        return [
            'id' => $this->id,
            'name' => $this->name,
            'item_id' => $this->item_id,
            'code' => $this->code,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'image_id' => $this->image_id,
            'link' => $link,
            'attribute_ids' => $variantAttributeIds,
            'attribute_group_ids' => $attributeGroupIds,
            'item_variant_attributes' => $this->itemVariantAttributes,
        ];
    }
}
