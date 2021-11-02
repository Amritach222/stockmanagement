<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{

    protected $table = 'brands';
    public $timestamps = true;
    protected $fillable = array('name', 'image_id');

    public function products()
    {
        return $this->hasMany(Product::class, 'brand_id');
    }

    public function items()
    {
        return $this->hasMany(Item::class, 'brand_id');
    }

}
