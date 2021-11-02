<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccountTransaction extends Model
{

    protected $table = 'bank_account_transactions';
    public $timestamps = true;
    protected $fillable = array('account_id', 'transaction_amount', 'transaction_type');

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class, 'account_id');
    }
}
