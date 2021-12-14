<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseProduct extends Model
{

    protected $table = 'purchase_products';
    public $timestamps = true;
    protected $fillable = array('purchase_id', 'product_id', 'product_variant_id', 'vendor_id', 'quantity', 'price', 'tax_id', 'total_price', 'unit_id','status');

    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function tax()
    {
        return $this->belongsTo(Tax::class, 'tax_id');
    }

    public function returnProducts()
    {
        return $this->hasMany(ReturnProduct::class, 'purchase_product_id');
    }

    public function taxAmount()
    {
        $taxValue = 0;
        if ($this->tax_id !== null) {
            $tax = Tax::findOrFail($this->tax_id);
            $taxValue = ($tax->value / 100) * $this->quantity * $this->price;
        }
        return $taxValue;
    }

    public function taxCalculate()
    {
        $taxValue = $this->taxAmount();
        $this->total_price = $this->quantity * $this->price + $taxValue;
        $this->save();
    }
}
