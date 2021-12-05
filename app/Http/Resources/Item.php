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
        $currentUser = \App\Models\ItemUser::where('item_id', $this->id)->orderBy('created_at', 'desc')->first();
        $user = $currentUser->user ?? null;
        $itemUsers = ItemUser::collection($this->users);
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
            'user_id' => $user->id ?? null,
            'link' => $link,
            'product' => $product,
            'product_variant' => $variant,
            'brand' => $brand,
            'unit' => $unit,
            'user' => $user,
            'item_users' => $itemUsers,
        ];
    }
}
