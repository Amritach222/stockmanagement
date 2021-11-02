<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{

    protected $table = 'taxes';
    public $timestamps = true;
    protected $fillable = array('name', 'value');

    public function items()
    {
        return $this->hasMany(Item::class, 'tax_id');
    }

    public function purchaseProducts()
    {
        return $this->hasMany(PurchaseProduct::class, 'tax_id');
    }

    public function quotationProducts()
    {
        return $this->hasMany(QuotationProduct::class, 'tax_id');
    }
}
