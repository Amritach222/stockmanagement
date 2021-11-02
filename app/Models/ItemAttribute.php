<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemAttribute extends Model
{

    protected $table = 'item_attributes';
    public $timestamps = true;
    protected $fillable = array('name', 'attribute_group_id');


    public function itemVariantAttributes()
    {
        return $this->hasMany(ItemVariantAttribute::class, 'attribute_id');
    }

    public function variants()
    {
        return $this->belongsToMany(ItemVariant::class,'item_variant_attributes','attribute_id');
    }

}
