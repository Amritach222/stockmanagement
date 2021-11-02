<?php

namespace App\Http\Resources;

use App\Models\File;
use Illuminate\Http\Resources\Json\JsonResource;

class Brand extends JsonResource
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
        if($this->image_id !== null){
            $image = File::where('id',$this->image_id)->first();
            $link = $image->path;
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image_id' => $this->image_id,
            'link' => $link,
        ];
    }
}
