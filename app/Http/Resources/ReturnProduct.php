<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use function Symfony\Component\Translation\t;

class ReturnProduct extends JsonResource
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
            'reference_no' => $this->reference_no,
            'purchase_id' => $this->purchase_id,
            'purchase_product_id' => $this->purchase_product_id,
            'quantity' => $this->quantity,
            'shipping_cost' => $this->shipping_cost,
            'total_cost' => $this->total_cost,
            'user_id' => $this->user_id,
            'note' => $this->note,
            'file_id' => $this->file_id
        ];
    }
}
