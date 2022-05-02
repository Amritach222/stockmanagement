<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RegisterPaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
//        $invoices = $this->invoices;
//        $due_amount = $this->grand_total;
//        foreach($invoices as $invoice){
//            $invoice->due_amount = $due_amount - $invoice->amount;
//            $due_amount = $invoice->due_amount;
//        }
        $invoices = InvoiceResource::collection($this->invoices);
        return [
            'id' => $this->id,
            'reference_no' => $this->reference_no,
            'purchase_order_id' => $this->purchase_order_id,
            'total' => $this->total,
            'discount' => $this->discount,
            'tax_id' => $this->tax_id,
            'shipping_cost' => $this->shipping_cost,
            'grand_total' => $this->grand_total,
            'due_amount' => $this->due_amount,
            'invoices' => $invoices
        ];
    }
}
