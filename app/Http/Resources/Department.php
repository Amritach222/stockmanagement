<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Department extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $user = new AuthResource($this->headOfDepartment);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'head_of_department' => $this->head_of_department,
            'head_user_name'=>$user->name??'',
            'user_details' => $user,
        ];
    }
}
