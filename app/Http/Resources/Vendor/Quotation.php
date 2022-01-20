<?php

namespace App\Http\Resources\Vendor;

use App\Http\Resources\QuotationProduct;
use App\Http\Resources\VendorQuotation;
use App\Http\Resources\VendorQuotationProductResource;
use App\Models\File;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class Quotation extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $user = User::findOrFail(auth()->user()->id);
        $vendor = $user->vendor;
        $vendorQuotation = new VendorQuotation(\App\Models\VendorQuotation::where('quotation_id', $this->id)->where('vendor_id', $vendor->id)->firstOrFail());
        $quotation_product_ids = \App\Models\VendorQuotationProduct::where('vendor_quotation_id', $vendorQuotation->id)->pluck('quotation_product_id');
        $vendorQuotationProducts = VendorQuotationProductResource::collection(\App\Models\VendorQuotationProduct::where('vendor_quotation_id', $vendorQuotation->id)->get());
        $quotationProducts = QuotationProduct::collection(\App\Models\QuotationProduct::whereIn('id', $quotation_product_ids)->get());
//        $vendorQuotations = \App\Models\VendorQuotation::where('quotation_id', $this->id)->where('vendor_id', $vendor->id)->get();
        return [
            'id' => $this->id,
            'reference_no' => $this->reference_no,
            'note' => $this->note,
            'due_date' => $this->due_date,
            'desired_delivery_date' => $this->desired_delivery_date,
            'requested_name' => $this->requested_name,
            'status' => $this->status,
            'quotation_products' => $quotationProducts,
            'vendor_quotation' => $vendorQuotation,
            'vendor_quotation_products' => $vendorQuotationProducts
        ];
    }
}
