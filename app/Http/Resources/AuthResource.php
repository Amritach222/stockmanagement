<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    public static $wrap = 'data';

    /**
     * Transform the resource into an array.
     *
     * @return array
     */
    public function toArray($request)
    {
        if($this->is_vendor){
            $vendor_details = \App\Models\Vendor::where('user_id',$this->id)->first();
            return [
                'id' => $this->id,
                'email' => $this->email,
                'username' => $this->username,
                'name' => $this->name,
                'department_id' => $this->department_id,
                'is_active' => $this->is_active,
                'mobile_no' => $this->mobile_no,
                'address' => $this->address,
                'access_token' => $this->access_token,
                'vendor_details' => $vendor_details
            ];
        } else {
            return [
                'id' => $this->id,
                'email' => $this->email,
                'username' => $this->username,
                'name' => $this->name,
                'department_id' => $this->department_id,
                'is_active' => $this->is_active,
                'mobile_no' => $this->mobile_no,
                'address' => $this->address,
                'access_token' => $this->access_token,
            ];
        }
    }

    public function with($request)
    {
        return ['success' => true, 'message' => $this->responseMessage];
    }
}
