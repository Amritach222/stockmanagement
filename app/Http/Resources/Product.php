<?php

namespace App\Http\Resources;

use App\Models\File;
use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
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
        $variants = ProductVariant::collection($this->productVariants);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'brand_id' => $this->brand_id,
            'category_id' => $this->category_id,
            'cost_price' => $this->cost_price,
            'stock' => $this->stock,
            'alert_stock' => $this->alert_stock,
            'unit_id' => $this->unit_id,
            'distribute_unit_id' => $this->distribute_unit_id,
            'tax_id' => $this->tax_id,
            'tax_method' => $this->tax_method,
            'image_id' => $this->image_id,
            'is_active' => $this->is_active,
            'details' => $this->details,
            'type' => $this->type,
            'items' => $this->items,
            'link' => $link,
            'brand' => $this->brand,
            'category' => $this->category,
            'product_variants' => $variants,
            'unit' => $this->unit,
            'distribute_unit' => $this->distributeUnit,
        ];
    }
}
