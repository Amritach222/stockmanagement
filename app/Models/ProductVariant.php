<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{

    protected $table = 'product_variants';
    public $timestamps = true;
    protected $fillable = array('product_id', 'code', 'price', 'quantity', 'image_id');
    protected $appends = ['name'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function attributes()
    {
        return $this->belongsToMany(ProductAttribute::class, 'product_variant_attributes', 'product_variant_id', 'attribute_id');
    }

    public function getNameAttribute()
    {
        $name = '';
        foreach ($this->productVariantAttributes as $i => $variantAttribute) {
            if ($i > 0) {
                $name = $name . ', ' . $variantAttribute->productAttribute->name;
            } else {
                $name = $name . $variantAttribute->productAttribute->name;
            }
        }
        return $name;
    }

    public function productVariantAttributes()
    {
        return $this->hasMany(ProductVariantAttribute::class, 'product_variant_id');
    }

    public function purchaseProducts()
    {
        return $this->hasMany(PurchaseProduct::class, 'product_variant_id');
    }

    public function quotationProducts()
    {
        return $this->hasMany(QuotationProduct::class, 'product_variant_id');
    }

    public function image()
    {
        return $this->belongsTo(File::class, 'image_id');
    }
}
