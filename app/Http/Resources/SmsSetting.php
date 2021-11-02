<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SmsSetting extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'gateway' => $this->gateway,
            'api_key' => $this->api_key
        ];
    }
}
