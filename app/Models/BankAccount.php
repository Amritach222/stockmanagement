<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{

    protected $table = 'bank_accounts';
    public $timestamps = true;
    protected $fillable = array('bank_name', 'account_no', 'account_name', 'total_balance', 'current_balance', 'branch');

    public function expenses()
    {
        return $this->hasMany(Expense::class, 'bank_account_id');
    }

    public function bankAccountTransactions()
    {
        return $this->hasMany(BankAccountTransaction::class, 'account_id');
    }

    public function subBalance($amount, $changeTotal = false)
    {
        $this->current_balance = $this->current_balance - $amount;
        if ($changeTotal === true) {
            $this->total_balance = $this->total_balance - $amount;
        }
        $this->save();
    }

    public function addBalance($amount, $changeTotal = false)
    {
        $this->current_balance = $this->current_balance + $amount;
        if ($changeTotal === true) {
            $this->total_balance = $this->total_balance + $amount;
        }
        $this->save();
    }

    public function changeBalance($addAmount, $subAmount, $changeTotal = false)
    {
        $this->current_balance = $this->current_balance + $addAmount - $subAmount;
        if ($changeTotal === true) {
            $this->total_balance = $this->total_balance + $addAmount - $subAmount;
        }
        $this->save();
    }
}
