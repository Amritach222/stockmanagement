<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{

    protected $table = 'vendors';
    public $timestamps = true;
    protected $fillable = array('name', 'company_name', 'image_id', 'vat_no', 'email', 'address', 'landline', 'mobile', 'country', 'state', 'city', 'postal_code', 'category_id', 'is_active');

    public function purchaseProducts()
    {
        return $this->hasMany(PurchaseProduct::class, 'vendor_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'vendor_products', 'vendor_id', 'product_id');
    }

    public function vendorProducts()
    {
        return $this->hasMany(VendorProduct::class, 'vendor_id');
    }
}
