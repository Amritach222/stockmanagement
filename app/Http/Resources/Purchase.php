<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Purchase extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $department =  (object) ["name" => "Not Found"];
        $file =  (object) ["path" => "Not Found"];
        $due_date =  "Not Found";
        $item_short = 'Not Found';
        $note = 'There is no note for this request';
        if($this->department_id){
            $department = \App\Models\Department::where('id', $this->department_id)->first();
        }
        if($this->file_id){
            $file = \App\Models\File::where('id', $this->file_id)->first();
        }

        if(!empty($this->purchaseProducts->toArray())){
            $item_short = '';
            forEach($this->purchaseProducts->toArray() as $data){
                $item = \App\Models\Product::where('id',$data['product_id'])->first();
                $item_short = $item_short.$item->name."(".$data['quantity'].") ";
            }
        }

        if($this->due_date){
            $due_date = date('F j, Y', strtotime($this->due_date));
        }

        if($this->note){
            $note = $this->note;
        }

        return [
            'id' => $this->id,
            'reference_no' => $this->reference_no,
            'user_id' => $this->user_id,
            'department_id' => $this->department_id,
            'department_name' => $department->name,
            'total_item' => $this->total_item,
            'total_quantity' => $this->total_quantity,
            'total_tax' => $this->total_tax,
            'total_cost' => $this->total_cost,
            'shipping_cost' => $this->shipping_cost,
            'grand_total' => $this->grand_total,
            'paid_amount' => $this->paid_amount,
            'status' => $this->status,
            'payment_status' => $this->payment_status,
            'file_id' => $this->file_id,
            'file_link' => $file->path,
            'due_date_formal' => $this->due_date,
            'due_date' => $due_date,
            'note' => $note,
            'approved_by' => $this->approved_by,
            'seen_status' => $this->seen_status,
            'purchase_products' => $this->purchaseProducts,
            'purchase_products_shortcode' => $item_short,
        ];
    }
}
