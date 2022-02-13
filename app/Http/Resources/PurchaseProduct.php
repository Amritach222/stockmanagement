<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseProduct extends JsonResource
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
            'purchase_id' => $this->purchase_id,
            'product_id' => $this->product_id,
            'product_variant_id' => $this->product_variant_id,
            'vendor_id' => $this->vendor_id,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'tax_id' => $this->tax_id,
            'unit_id' => $this->unit_id,
            'total_price' => $this->total_price,
            'department_status' => $this->department_status
        ];
    }
}
