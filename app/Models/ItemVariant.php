<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemVariant extends Model
{

    protected $table = 'item_variants';
    public $timestamps = true;
    protected $fillable = array('item_id', 'code', 'price', 'quantity', 'image_id');
    protected $appends = ['name'];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function attributes()
    {
        return $this->belongsToMany(ItemAttribute::class, 'item_variant_attributes', 'item_variant_id', 'attribute_id');
    }

    public function getNameAttribute()
    {
        $name = '';
        foreach ($this->itemVariantAttributes as $i => $variantAttribute) {
            if ($i > 0) {
                $name = $name . ', ' . $variantAttribute->itemAttribute->name;
            } else {
                $name = $name . $variantAttribute->itemAttribute->name;
            }
        }
        return $name;
    }

    public function itemVariantAttributes()
    {
        return $this->hasMany(ItemVariantAttribute::class, 'item_variant_id');
    }

    public function consumes()
    {
        return $this->hasMany(Consume::class, 'item_variant_id');
    }

    public function purchaseProducts()
    {
        return $this->hasMany(PurchaseProduct::class, 'item_variant_id');
    }

    public function quotationProducts()
    {
        return $this->hasMany(QuotationProduct::class, 'item_variant_id');
    }

    public function transfers()
    {
        return $this->hasMany(Transfer::class, 'item_variant_id');
    }

    public function unusedProducts()
    {
        return $this->hasMany(UnusedProduct::class, 'item_variant_id');
    }

    public function image()
    {
        return $this->belongsTo(File::class, 'image_id');
    }
}
