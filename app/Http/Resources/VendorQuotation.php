<?php

namespace App\Http\Resources;

use App\Models\File;
use Illuminate\Http\Resources\Json\JsonResource;

class VendorQuotation extends JsonResource
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
        if ($this->file_id !== null) {
            $image = File::where('id', $this->file_id)->first();
            $link = $image->path;
        }
        $products = VendorQuotationProductResource::collection($this->vendorQuotationProducts);
        return [
            'id' => $this->id,
            'quotation_id' => $this->quotation_id,
            'vendor_id' => $this->vendor_id,
            'total_item' => $this->total_item,
            'total_price' => $this->total_price,
            'discount_type' => $this->discount_type,
            'discount' => $this->discount,
            'grand_total'=>$this->grand_total,
            'status' => $this->status,
            'comment' => $this->comment,
            'file_id' => $this->file_id,
            'link' => $link,
            'vendor_quotation_products' => $products,
        ];
    }
}
