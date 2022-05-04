<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{

    protected $table = 'purchases';
    public $timestamps = true;
    protected $fillable = array('reference_no', 'user_id', 'department_id', 'total_item', 'total_quantity', 'total_tax', 'total_cost','due_date', 'shipping_cost', 'grand_total', 'paid_amount', 'status', 'payment_status', 'note', 'file_id', 'approved_by', 'seen_status');

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function purchaseProducts()
    {
        return $this->hasMany(PurchaseProduct::class, 'purchase_id');
    }

    public function returnProducts()
    {
        return $this->hasMany(ReturnProduct::class, 'purchase_id');
    }

    public function total()
    {
        $this->total_item = count($this->purchaseProducts);
        $total_quantity = 0;
        $total_cost = 0;
        $total_tax = 0;
        foreach ($this->purchaseProducts as $product) {
            $total_quantity = $product->quantity + $total_quantity;
            $total_cost = $product->price * $product->quantity + $total_cost;
            $total_tax = $product->taxAmount() + $total_tax;
        }
        $this->total_quantity = $total_quantity;
        $this->total_cost = $total_cost;
        $this->total_tax = $total_tax;
        $this->grand_total = $total_cost + $this->shipping_cost + $total_tax;
        $this->save();
    }
}
