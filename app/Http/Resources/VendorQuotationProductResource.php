<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VendorQuotationProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $quotationProduct = new QuotationProduct($this->quotationProduct);
        $vendorQuotation = $this->vendorQuotation;
        $tax = null;
        if ($this->tax_id !== null) {
            $tax = new Tax(\App\Models\Tax::findOrFail($this->tax_id));
        }
        $total = $this->quantity * $this->price;
        return [
            'id' => $this->id,
            'vendor_quotation_id' => $this->vendor_quotation_id,
            'quotation_product_id' => $this->quotation_product_id,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'total' => $total,
            'discount_type' => $this->discount_type,
            'discount' => $this->discount,
            'tax_id' => $this->tax_id,
            'status' => $this->status,
            'shipping_cost' => $this->shipping_cost,
            'grand_total' => $this->total,
            'quotation_product' => $quotationProduct,
            'tax' => $tax,
            'vendor_quotation_status' => $vendorQuotation->status ?? '',
        ];
    }
}
