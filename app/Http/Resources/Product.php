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
            'image_id' => $this->image_id,
            'is_active' => $this->is_active,
            'details' => $this->details,
            'items' => $this->items,
            'link' => $link,
            'brand' => $this->brand,
            'category' => $this->category,
            'product_variants' => $variants,
        ];
    }
}
