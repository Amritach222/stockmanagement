<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemAttributeGroup extends Model
{

    protected $table = 'item_attribute_groups';
    public $timestamps = true;
    protected $fillable = array('name');

    public function attributes()
    {
        return $this->hasMany(ItemAttribute::class, 'attribute_group_id');
    }

    public function itemVariantAttributes()
    {
        return $this->hasMany(ItemVariantAttribute::class, 'attribute_group_id');
    }
}
