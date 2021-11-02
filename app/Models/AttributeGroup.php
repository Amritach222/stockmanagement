<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeGroup extends Model 
{

    protected $table = 'item_attribute_groups';
    public $timestamps = true;
    protected $fillable = array('name');

}