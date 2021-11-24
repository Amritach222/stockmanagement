<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuotationProduct extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $item = new Item($this->item);
        $itemVariant = $this->item_variant_id ? new ItemVariant($this->itemVariant) : null;
        $tax = $this->tax_id ? new Tax($this->tax) : null;
        return [
            'id' => $this->id,
            'quotation_id' => $this->quotation_id,
            'item_id' => $this->item_id,
            'item_variant_id' => $this->item_variant_id,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'tax_id' => $this->tax_id,
            'shipping_cost' => $this->shipping_cost??0,
            'grand_total' => $this->grand_total,
            'item' => $item,
            'item_variant' => $itemVariant,
            'tax' => $tax,
        ];
    }
}
