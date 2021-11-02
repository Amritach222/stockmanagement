<?php

namespace App\Http\Resources;

use App\Models\File;
use Illuminate\Http\Resources\Json\JsonResource;

class Setting extends JsonResource
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
        if ($this->logo_id !== null) {
            $image = File::where('id', $this->logo_id)->first();
            $link = $image->path;
        }
        return [
            'id' => $this->id,
            'title' => $this->title,
            'logo_id' => $this->logo_id,
            'currency' => $this->currency,
            'time_zone' => $this->time_zone,
            'date_format' => $this->date_format,
            'fiscal_year_id' => $this->fiscal_year_id,
            'link' => $link,
        ];
    }
}
