<?php

namespace App\Http\Resources;

use App\Models\File;
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
        $department = new Department($this->department);
        $user = new AuthResource($this->user);
        $link = null;
        if ($this->file_id !== null) {
            $image = File::where('id', $this->file_id)->first();
            $link = $image->path;
        }
        $quotationProducts = QuotationProduct::collection($this->quotationProducts);
        $vendorQuotations = \App\Models\VendorQuotation::where('quotation_id', $this->id)->get();
        $vendor_ids = \App\Models\VendorQuotation::where('quotation_id', $this->id)->pluck('vendor_id');
        $vendors = \App\Models\Vendor::whereIn('id', $vendor_ids)->get();
        foreach ($vendors as $vendor) {
            $vendor->status = $this->getVendorStatus($vendor->id);
        }
        $is_pending = $this->isPending();
        return [
            'id' => $this->id,
            'reference_no' => $this->reference_no,
            'user_id' => $this->user_id,
            'department_id' => $this->department_id,
            'file_id' => $this->file_id,
            'note' => $this->note,
            'due_date' => $this->due_date,
            'desired_delivery_date' => $this->desired_delivery_date,
            'requested_name' => $this->requested_name,
            'status' => $this->status,
            'reviewed_by' => $this->reviewed_by,
            'approved_by' => $this->approved_by,
            'is_pending' => $is_pending,
            'link' => $link,
            'quotation_products' => $quotationProducts,
            'department' => $department,
            'user' => $user,
            'vendors' => $vendors,
            'vendor_quotations' => $vendorQuotations
        ];
    }
}
