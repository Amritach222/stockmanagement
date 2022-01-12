<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VendorQuotation extends JsonResource
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
            'quotation_id' => $this->quotation_id,
            'quotation_product_id' => $this->quotation_product_id,
            'vendor_id' => $this->vendor_id,
            'price' => $this->price,
            'quantity' => $this->quantity,
        ];
    }
}
