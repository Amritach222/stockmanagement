<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Vendor extends JsonResource
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
            'name' => $this->name,
            'company_name' => $this->company_name,
            'vat_no' => $this->vat_no,
            'email' => $this->email,
            'landline' => $this->landline,
            'mobile' => $this->mobile,
            'country' => $this->country,
            'state' => $this->state,
            'city' => $this->city,
            'postal_code' => $this->postal_code,
            'category_id' => $this->category_id,
            'is_active' => $this->is_active
        ];
    }
}
