<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariantAttribute extends Model
{

    protected $table = 'product_variant_attributes';
    public $timestamps = true;
    protected $fillable = array('product_variant_id', 'attribute_group_id', 'attribute_id');

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    public function productAttributeGroup()
    {
        return $this->belongsTo(ProductAttributeGroup::class, 'attribute_group_id');
    }

    public function productAttribute()
    {
        return $this->belongsTo(ProductAttribute::class, 'attribute_id');
    }
}
