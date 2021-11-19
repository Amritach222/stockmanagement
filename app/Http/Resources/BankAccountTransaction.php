<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BankAccountTransaction extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $bankName = null;
        if ($this->account_id) {
            $bank = \App\Models\BankAccount::find($this->account_id);
            $bankName = $bank->bank_name;
        }
        return [
            'id' => $this->id,
            'account_id' => $this->account_id,
            'transaction_amount' => $this->transaction_amount,
            'transaction_type' => $this->transaction_type,
            'bank_name' => $bankName,
        ];
    }
}
