<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UnusedProduct extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'item_id' => $this->item_id,
            'item_variant_id' => $this->item_variant_id,
            'department_id' => $this->department_id,
            'user_id' => $this->user_id,
            'approved_by' => $this->approved_by,
            'image_id' => $this->image_id,
            'note' => $this->note,
            'code' => $this->code,
        ];
    }
}
