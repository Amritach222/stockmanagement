<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{

    protected $table = 'items';
    public $timestamps = true;
    protected $fillable = array('name', 'code', 'product_id', 'stock', 'alert_stock', 'brand_id', 'unit_id', 'tax_id', 'tax_method', 'cost_price', 'image_ids');

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function tax()
    {
        return $this->belongsTo(Tax::class, 'tax_id');
    }

    public function itemVariants()
    {
        return $this->hasMany(ItemVariant::class, 'item_id');
    }

    public function consumes()
    {
        return $this->hasMany(Consume::class, 'item_id');
    }

    public function purchaseProducts()
    {
        return $this->hasMany(PurchaseProduct::class, 'item_id');
    }

    public function quotationProducts()
    {
        return $this->hasMany(QuotationProduct::class, 'item_id');
    }

    public function unusedProducts()
    {
        return $this->hasMany(UnusedProduct::class, 'item_id');
    }

    public function transfers()
    {
        return $this->hasMany(Transfer::class, 'item_id');
    }
}
