<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseOrderProduct extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $quotation_product=null;
        if($this->quotation_product_id !== null) {
            $quotation_product = new QuotationProduct($this->quotationProduct);
        }
        $product=null;
        if($this->product_id !== null){
            $product = new Product($this->product);
        }
        $product_variant=null;
        if($this->product_variant_id !== null){
            $product_variant = new ProductVariant($this->productVariant);
        }
        $unit=null;
        if($this->unit_id !== null){
            $unit = new Unit($this->unit);
        }
        $tax=null;
        if($this->tax_id !== null){
            $tax = new Tax($this->tax);
        }
        return [
            'id' => $this->id,
            'quotation_product_id' => $this->quotation_product_id,
            'product_id' => $this->product_id,
            'product_variant_id' => $this->product_variant_id,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'total' => $this->total,
            'unit_id' => $this->unit_id,
            'tax_id' => $this->tax_id,
            'shipping_cost' => $this->shipping_cost,
            'grand_total' => $this->grand_total,
            'quotation_product'=>$quotation_product,
            'product'=>$product,
            'product_variant'=>$product_variant,
            'unit'=>$unit,
            'tax'=>$tax,
        ];
    }
}
