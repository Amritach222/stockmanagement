<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BankAccount extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $transactions = BankAccountTransaction::collection($this->bankAccountTransactions);
        return [
            'id' => $this->id,
            'bank_name' => $this->bank_name,
            'account_no' => $this->account_no,
            'account_name' => $this->account_name,
            'total_balance' => $this->total_balance,
            'current_balance' => $this->current_balance,
            'branch' => $this->branch,
            'transactions' => $transactions,
        ];
    }
}
