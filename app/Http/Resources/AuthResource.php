<?php

namespace App\Http\Resources;

use App\Models\File;
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
        $link = null;
        if ($this->image_id !== null) {
            $image = File::where('id', $this->image_id)->first();
            $link = $image->path;
        }
        return [
            'id' => $this->id,
            'email' => $this->email,
            'username' => $this->username,
            'name' => $this->name,
            'department_id' => $this->department_id,
            'designation_id' => $this->designation_id,
            'is_active' => $this->is_active,
            'mobile_no' => $this->mobile_no,
            'address' => $this->address,
            'link' => $link,
        ];
    }

    public function with($request)
    {
        return ['success' => true, 'message' => $this->responseMessage];
    }
}
