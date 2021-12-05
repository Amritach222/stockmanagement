<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemUser extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $item = new Item($this->item);
        $user = new AuthResource($this->user);
        $department = new Department($this->department);
        return [
            'item_id' => $this->item_id,
            'user_id' => $this->user_id,
            'department_id' => $this->department_id,
            'item' => $item,
            'user' => $user,
            'department' => $department,
        ];
    }
}
