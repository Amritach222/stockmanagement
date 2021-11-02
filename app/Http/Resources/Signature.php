<?php

namespace App\Http\Resources;

use App\Models\File;
use Illuminate\Http\Resources\Json\JsonResource;

class Signature extends JsonResource
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
        $user = new AuthResource($this->user);
        $designation = new Designation($this->designation);
        return [
            'id' => $this->id,
            'file_id' => $this->file_id,
            'user_id' => $this->user_id,
            'designation_id' => $this->designation_id,
            'link' => $link,
            'user_name' => $user->name ?? '',
            'user' => $user,
            'designation_name' => $designation->name ?? '',
            'designation' => $designation,
        ];
    }
}
