<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $creation_date = $this->created_at->format('d/m/Y');
        return [
            'id' => $this->id,
            'payment_id' => $this->payment_id,
            'reference_no' => $this->reference_no,
            'amount' => $this->amount,
            'payment_type' => $this->payment_type,
            'issued_by' => $this->issued_by,
            'paid_to' => $this->paid_to,
            'description' => $this->description,
            'creation_date' => $creation_date,
            'due_amount' => '',
        ];
    }
}
