<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Transfer extends JsonResource
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
            'user_id' => $this->user_id,
            'from_department' => $this->from,
            'to_department' => $this->to,
            'item_id' => $this->item_id,
            'item_variant_id' => $this->item_variant_id,
            'total_quantity' => $this->total_quantity,
            'total_cost' => $this->total_cost,
            'total_tax' => $this->total_tax,
            'shipping_cost' => $this->shipping_cost,
            'grand_total' => $this->grand_total,
            'file_id' => $this->file_id,
            'note' => $this->note,
            'status' => $this->status,
        ];
    }
}
