<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttributeGroup extends Model
{

    protected $table = 'product_attribute_groups';
    public $timestamps = true;
    protected $fillable = array('name');

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class, 'attribute_group_id');
    }

    public function productVariantAttributes()
    {
        return $this->hasMany(ProductVariantAttribute::class, 'attribute_group_id');
    }
}
