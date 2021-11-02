<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnProduct extends Model
{

    protected $table = 'return_products';
    public $timestamps = true;
    protected $fillable = array('reference_no', 'user_id', 'purchase_id', 'purchase_product_id', 'quantity', 'shipping_cost', 'total_cost', 'note', 'file_id');

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id');
    }

    public function purchaseProduct()
    {
        return $this->belongsTo(PurchaseProduct::class, 'purchase_product_id');
    }

    public function file()
    {
        return $this->belongsTo(File::class, 'file_id');
    }
}
