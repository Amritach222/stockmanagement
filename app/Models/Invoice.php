<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function payment()
    {
        return $this->belongsTo(RegisterPayment::class, 'payment_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'issued_by');
    }
}
