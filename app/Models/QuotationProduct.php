<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuotationProduct extends Model
{

    protected $table = 'quotation_products';
    public $timestamps = true;
    protected $fillable = array('quotation_id', 'product_id', 'product_variant_id', 'quantity', 'price', 'tax_id', 'shipping_cost', 'grand_total', 'unit_id', 'discount_type', 'discount', 'purchase_product_id', 'vendor_id');

    public function quotation()
    {
        return $this->belongsTo(Quotation::class, 'quotation_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    public function tax()
    {
        return $this->belongsTo(Tax::class, 'tax_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
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
        if ($this->product->tax_method == 'Excluded') {
            $taxValue = $this->taxAmount();
            $this->grand_total = $this->quantity * $this->price + $taxValue + $this->shipping_cost;
        } else {
            $this->grand_total = $this->quantity * $this->price + $this->shipping_cost;
        }
        $this->save();
    }

    public function vendorQuotationProducts()
    {
        return $this->hasMany(VendorQuotationProduct::class, 'quotation_product_id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function purchaseOrderProducts()
    {
        return $this->hasMany(PurchaseOrderProduct::class, 'quotation_product_id');
    }
}
