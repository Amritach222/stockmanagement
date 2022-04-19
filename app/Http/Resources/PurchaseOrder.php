<?php

namespace App\Http\Resources;

use App\Models\File;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseOrder extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $department = null;
        if ($this->dept_id !== null) {
            $department = new Department($this->department);
        }
        $user = null;
        if ($this->user_id !== null) {
            $user = new AuthResource($this->user);
        }
        $vendor = null;
        if ($this->vendor_id !== null) {
            $vendor = new Vendor($this->vendor);
        }
        $link = null;
        if ($this->file_id !== null) {
            $image = File::where('id', $this->file_id)->first();
            $link = $image->path;
        }
        $purchaseOrderProducts = PurchaseOrderProduct::collection($this->purchaseOrderProducts);
        return [
            'id' => $this->id,
            'reference' => $this->reference,
            'date_of_order' => $this->date_of_order,
            'shipping_date' => $this->shipping_date,
            'received_date' => $this->received_date,
            'requester' => $this->requester,
            'user_id' => $this->user_id,
            'supplier' => $this->supplier,
            'vendor_id' => $this->vendor_id,
            'location' => $this->location,
            'dept_id' => $this->dept_id,
            'status' => $this->status,
            'description' => $this->description,
            'file_id' => $this->file_id,
            'total' => $this->total,
            'is_from_quotation' => $this->is_from_quotation,
            'department' => $department,
            'user' => $user,
            'vendor' => $vendor,
            'link' => $link,
            'purchase_order_products' => $purchaseOrderProducts,
        ];
    }
}
