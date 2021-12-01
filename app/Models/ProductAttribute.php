<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{

    protected $table = 'product_attributes';
    public $timestamps = true;
    protected $fillable = array('name', 'attribute_group_id');


    public function productVariantAttributes()
    {
        return $this->hasMany(ProductVariantAttribute::class, 'attribute_id');
    }

    public function variants()
    {
        return $this->belongsToMany(ProductVariant::class, 'product_variant_attributes', 'attribute_id');
    }

    public function productAttributeGroup()
    {
        return $this->belongsTo(ProductAttributeGroup::class, 'attribute_group_id');
    }

}
