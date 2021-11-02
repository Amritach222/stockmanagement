<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MailSetting extends JsonResource
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
            'mail_mailer' => $this->mail_mailer,
            'mail_host' => $this->mail_host,
            'mail_port' => $this->mail_port,
            'mail_address' => $this->mail_address,
            'username' => $this->username,
            'password' => $this->password,
            'mail_from_name' => $this->mail_from_name,
            'encryption' => $this->encryption
        ];
    }
}
