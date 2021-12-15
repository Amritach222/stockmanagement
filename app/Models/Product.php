<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $table = 'products';
    public $timestamps = true;
    protected $guarded = ['id'];

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function items()
    {
        return $this->hasMany(Item::class, 'product_id');
    }

    public function productVariants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id');
    }

    public function purchaseProducts()
    {
        return $this->hasMany(PurchaseProduct::class, 'product_id');
    }

    public function image()
    {
        return $this->belongsTo(File::class, 'image_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function distributeUnit()
    {
        return $this->belongsTo(Unit::class, 'distribute_unit_id');
    }

    public function vendors()
    {
        return $this->belongsToMany(Vendor::class, 'vendor_products', 'product_id', 'vendor_id');
    }

    public function vendorProducts()
    {
        return $this->hasMany(VendorProduct::class, 'product_id');
    }
}
