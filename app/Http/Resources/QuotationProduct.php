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
        $product = new Product($this->product);
        $productVariant = $this->product_variant_id ? new ProductVariant($this->productVariant) : null;
        $tax = $this->tax_id ? new Tax($this->tax) : null;
        $unit = $this->unit_id ? new Unit($this->unit) : null;
        $quotation = \App\Models\Quotation::findOrFail($this->quotation_id);
        $status = $quotation->getProductStatus($this->id);
        return [
            'id' => $this->id,
            'quotation_id' => $this->quotation_id,
            'product_id' => $this->product_id,
            'product_variant_id' => $this->product_variant_id,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'tax_id' => $this->tax_id,
            'unit_id' => $this->unit_id,
            'shipping_cost' => $this->shipping_cost ?? 0,
            'discount_type' => $this->discount_type,
            'discount' => $this->discount,
            'grand_total' => $this->grand_total,
            'purchase_product_id' => $this->purchase_product_id,
            'product' => $product,
            'product_variant' => $productVariant,
            'tax' => $tax,
            'unit' => $unit,
            'status' => $status,
        ];
    }
}
