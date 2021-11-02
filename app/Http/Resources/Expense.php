<?php

namespace App\Http\Resources;

use App\Models\File;
use Illuminate\Http\Resources\Json\JsonResource;

class Expense extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $user = new AuthResource($this->user);
        $department = new Department($this->department);
        $bank_account = new BankAccount($this->bankAccount);
        $expense_category = new ExpenseCategory($this->expenseCategory);
        $creator = new AuthResource($this->creator);

        $link = null;
        if ($this->file_id !== null) {
            $image = File::where('id', $this->file_id)->first();
            $link = $image->path;
        }
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'amount' => $this->amount,
            'transaction_type' => $this->transaction_type,
            'bank_account_id' => $this->bank_account_id,
            'cheque_no' => $this->cheque_no,
            'department_id' => $this->department_id,
            'status' => $this->status,
            'expense_category_id' => $this->expense_category_id,
            'created_by' => $this->created_by,
            'note' => $this->note,
            'link' => $link,
            'user' => $user,
            'department' => $department,
            'bank_account' => $bank_account,
            'expense_category' => $expense_category,
            'creator' => $creator,
        ];
    }
}
