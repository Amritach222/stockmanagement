<?php

namespace App\Http\Resources;

use App\Models\File;
use App\Models\User;
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
        $link = null;
        if ($this->image_id !== null) {
            $image = File::where('id', $this->image_id)->first();
            $link = $image->path;
        }
        $user = null;
        if ($this->user_id !== null) {
            $user = User::findOrFail($this->user_id);
        }
        $category = new Category($this->category);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $user->username ?? '',
            'company_name' => $this->company_name,
            'vat_no' => $this->vat_no,
            'email' => $this->email,
            'landline' => $this->landline,
            'mobile' => $this->mobile,
            'address' => $this->address,
            'country' => $this->country,
            'state' => $this->state,
            'city' => $this->city,
            'postal_code' => $this->postal_code,
            'category_id' => $this->category_id,
            'is_active' => $this->is_active,
            'link' => $link,
            'category' => $category,
        ];
    }
}
