<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{

    protected $table = 'units';
    public $timestamps = true;
    protected $fillable = array('name', 'short_code', 'parent_id', 'value');

    public function items()
    {
        return $this->hasMany(Item::class, 'unit_id');
    }

    public function parent()
    {
        return $this->belongsTo(Unit::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Unit::class, 'parent_id');
    }
}
