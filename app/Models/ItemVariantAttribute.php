<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemVariantAttribute extends Model
{

    protected $table = 'item_variant_attributes';
    public $timestamps = true;
    protected $fillable = array('item_variant_id', 'attribute_group_id', 'attribute_id');

    public function itemVariant()
    {
        return $this->belongsTo(ItemVariant::class, 'item_variant_id');
    }

    public function itemAttributeGroup()
    {
        return $this->belongsTo(ItemAttributeGroup::class, 'attribute_group_id');
    }

    public function itemAttribute()
    {
        return $this->belongsTo(ItemAttribute::class, 'attribute_id');
    }
}
