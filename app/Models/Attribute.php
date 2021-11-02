<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model 
{

    protected $table = 'item_attributes';
    public $timestamps = true;
    protected $fillable = array('name', 'attribute_group_id');

}