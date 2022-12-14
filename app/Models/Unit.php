<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{

    protected $table = 'units';
    public $timestamps = true;
    protected $fillable = array('name', 'short_code', 'category_id', 'type', 'value');

    public function items()
    {
        return $this->hasMany(Item::class, 'unit_id');
    }

    public function category()
    {
        return $this->belongsTo(UnitCategory::class, 'category_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'unit_id');
    }

    public function distributeProducts()
    {
        return $this->hasMany(Product::class, 'distribute_unit_id');
    }
}
