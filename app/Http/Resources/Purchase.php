<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Purchase extends JsonResource
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
            'department_id' => $this->department_id,
            'total_item' => $this->total_item,
            'total_quantity' => $this->total_quantity,
            'total_tax' => $this->total_tax,
            'total_cost' => $this->total_cost,
            'shipping_cost' => $this->shipping_cost,
            'grand_total' => $this->grand_total,
            'paid_amount' => $this->paid_amount,
            'status' => $this->status,
            'payment_status' => $this->payment_status,
            'file_id' => $this->file_id,
            'note' => $this->note,
            'approved_by' => $this->approved_by,
            'delivery_status' => $this->delivery_status,
            'purchase_products' => $this->purchaseProducts,
        ];
    }
}
