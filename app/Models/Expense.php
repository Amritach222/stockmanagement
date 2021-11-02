<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{

    protected $table = 'expenses';
    public $timestamps = true;
    protected $fillable = array('reference_no', 'user_id', 'department_id', 'expense_category_id', 'amount', 'transaction_type', 'bank_account_id', 'cheque_no', 'status', 'note', 'file_id');

    public function expenseCategory()
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class, 'bank_account_id');
    }

    public function file()
    {
        return $this->belongsTo(File::class, 'file_id');
    }
}
