<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{

    protected $table = 'designations';
    public $timestamps = true;
    protected $fillable = array('name', 'level');

    public function signatures()
    {
        return $this->hasMany(Signature::class, 'designation_id');
    }
}
