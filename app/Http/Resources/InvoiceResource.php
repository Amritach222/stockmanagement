<?php

namespace App\Http\Resources;

use App\Models\User;
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
        $issuer = null;
        if ($this->issued_by !== null) {
            $issuer = new AuthResource(User::findOrFail($this->issued_by));
        }
        $paidTo = null;
        if ($this->paid_to !== null) {
            $paidTo = new Vendor(\App\Models\Vendor::findOrFail($this->paid_to));
        }
        return [
            'id' => $this->id,
            'payment_id' => $this->payment_id,
            'payment_reference' => $this->payment->reference_no,
            'reference_no' => $this->reference_no,
            'amount' => $this->amount,
            'payment_type' => $this->payment_type,
            'issued_by' => $this->issued_by,
            'paid_to' => $this->paid_to,
            'description' => $this->description,
            'creation_date' => $creation_date,
            'due_amount' => '',
            'issuer' => $issuer,
            'vendor' => $paidTo,
        ];
    }
}
