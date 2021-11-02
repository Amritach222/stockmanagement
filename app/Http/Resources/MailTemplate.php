<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MailTemplate extends JsonResource
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
            'title' => $this->title,
            'view_page' => $this->view_page,
            'content' => $this->content,
        ];
    }
}
