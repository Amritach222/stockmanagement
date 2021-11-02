<?php

namespace App\Http\Resources;

use App\Models\File;
use Illuminate\Http\Resources\Json\JsonResource;

class SignatureUseDepartment extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $link=null;
        $department = new Department($this->department);
        $signature = new Signature($this->signature);
        if ($signature->file_id !== null) {
            $image = File::where('id', $signature->file_id)->first();
            $link = $image->path;
        }
        return [
            'id' => $this->id,
            'department_id' => $this->department_id,
            'signature_id' => $this->signature_id,
            'department_name' => $department->name ?? '',
            'department' => $department,
            'link' => $link,
            'signature' => $signature,
        ];
    }
}
