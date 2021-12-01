<?php

namespace App\Http\Resources;

use App\Models\File;
use Illuminate\Http\Resources\Json\JsonResource;

class Item extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $link = null;
        if ($this->image_id !== null) {
            $image = File::where('id', $this->image_id)->first();
            $link = $image->path;
        }
        $variant = new ProductVariant($this->productVariant);
        $product = new Product($this->product);
        $brand = new Brand($this->brand);
        $unit = new Unit($this->unit);
        $tax = new Tax($this->tax);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'product_id' => $this->product_id,
            'brand_id' => $this->brand_id,
            'image_ids' => $this->image_ids,
            'stock' => $this->stock,
            'alert_stock' => $this->alert_stock,
            'cost_price' => $this->cost_price,
            'unit_id' => $this->unit_id,
            'tax_id' => $this->tax_id,
            'tax_method' => $this->tax_method,
            'link' => $link,
            'product' => $product,
            'product_variant' => $variant,
            'brand' => $brand,
            'tax' => $tax,
            'unit' => $unit,
        ];
    }
}
