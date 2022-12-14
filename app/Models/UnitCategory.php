<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnitCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name'];

    public function units()
    {
        return $this->hasMany(Unit::class, 'category_id');
    }
}
